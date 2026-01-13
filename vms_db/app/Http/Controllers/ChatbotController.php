<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        try {
            $webhookUrl = config('services.webhook.url');
            
            if (!$webhookUrl) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service configuration error'
                ], 500);
            }

            $user = Auth::user();
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . config('jwt.secret')
                ])
                ->post($webhookUrl, [
                    'message' => $request->message,
                    'user_id' => $user ? $user->id : null,
                    'user_name' => $user ? ($user->name ?? 'Admin') : 'Admin',
                    'timestamp' => now()->toIso8601String()
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return response()->json([
                    'success' => true,
                    'response' => $data['response'] ?? $data['message'] ?? 'Response received',
                ]);
            }

            Log::warning('External service error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to process request at this time'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request'
            ], 500);
        }
    }
}
