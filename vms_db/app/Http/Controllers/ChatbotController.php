<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $webhookUrl = config('services.webhook.url');

            if (! $webhookUrl) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service configuration error',
                ], 500);
            }

            $user = Auth::user();

            // Generate JWT token matching n8n's expected format
            try {
                // Use plainText encoding instead of base64
                $config = Configuration::forSymmetricSigner(
                    new Sha256,
                    InMemory::plainText(config('jwt.secret'))
                );

                $now = time(); // Unix timestamp
                $token = $config->builder()
                    ->identifiedBy(uniqid('vms_', true)) // jti claim
                    ->relatedTo($user ? $user->email : 'admin@system') // sub claim (user identifier)
                    ->issuedAt(\DateTimeImmutable::createFromFormat('U', (string) $now))
                    ->expiresAt(\DateTimeImmutable::createFromFormat('U', (string) ($now + 86400))) // 24 hours
                    ->getToken($config->signer(), $config->signingKey())
                    ->toString();

                Log::info('JWT token generated', [
                    'token_preview' => substr($token, 0, 50).'...',
                    'user_email' => $user ? $user->email : 'admin@system',
                ]);
            } catch (\Exception $e) {
                Log::error('JWT generation failed: '.$e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Authentication error',
                ], 500);
            }

            // Generate session ID based on user email (consistent across requests)
            $userEmail = $user ? $user->email : 'admin@system';
            $sessionId = 'chat-'.$userEmail.'-'.uniqid();

            // Check if session ID exists in session, otherwise create new one
            $sessionId = session('chatbot_session_id', $sessionId);
            session(['chatbot_session_id' => $sessionId]);

            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$token,
                ])
                ->post($webhookUrl, [
                    'sessionId' => $sessionId,
                    'message' => $request->message,
                    'user_id' => $user ? $user->id : null,
                    'user_name' => $user ? ($user->name ?? 'Admin') : 'Admin',
                    'timestamp' => now()->toIso8601String(),
                ]);

            if ($response->successful()) {
                $data = $response->json();

                // Extract output from n8n response format: [{"output": "text"}]
                $responseText = 'Response received';
                if (is_array($data) && isset($data[0]['output'])) {
                    $responseText = $data[0]['output'];
                } elseif (isset($data['output'])) {
                    $responseText = $data['output'];
                } elseif (isset($data['response'])) {
                    $responseText = $data['response'];
                } elseif (isset($data['message'])) {
                    $responseText = $data['message'];
                }

                return response()->json([
                    'success' => true,
                    'response' => $responseText,
                ]);
            }

            Log::warning('External service error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to process request at this time',
            ], 500);

        } catch (\Exception $e) {
            Log::error('Chatbot error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request',
            ], 500);
        }
    }
}
