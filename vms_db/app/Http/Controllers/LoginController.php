<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();

                // Redirect based on role
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!');
                }

                // For volunteers, redirect to volunteer dashboard if they have a profile
                $volunteer = Volunteer::where('user_id', $user->id)->first();
                if ($volunteer) {
                    return redirect("/volunteer/{$volunteer->id}/dashboard")->with('success', 'Logged in successfully!');
                }

                // If no volunteer profile yet, redirect to form
                return redirect('/volunteer-form')->with('success', 'Logged in! Please complete your volunteer profile.');
            }

            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully!');
    }
}
