<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VolunteerController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Check if user already has a volunteer profile (excluding soft-deleted records)
            if (Volunteer::where('user_id', Auth::id())->whereNull('deleted_at')->exists()) {
                return redirect('/volunteer/'.Auth::user()->volunteer->id.'/dashboard')
                    ->with('info', 'You already have a volunteer profile.');
            }

            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'mobile' => 'required|string|max:20',
                'facebook_name' => 'nullable|string|max:255',
                'birthdate' => 'required|date',
                'address' => 'required|string',
                'education' => 'required|string|max:100',
                'training' => 'nullable|string',
                'skills' => 'nullable|string',
                'classes' => 'nullable|string',
                'availability' => 'required|array|min:1',
                'volunteer_area' => 'required|string|max:255',
                'lifegroup' => 'required|in:yes,no',
                'emergency_name' => 'required|string|max:255',
                'emergency_relation' => 'required|string|max:255',
                'emergency_phone' => 'required|string|max:20',
                'emergency_email' => 'nullable|string|email|max:255',
            ]);

            // Convert availability array to string for storage
            $validated['availability'] = implode(', ', $validated['availability']);
            $validated['user_id'] = Auth::id();

            // Save to database
            $volunteer = Volunteer::create($validated);

            // Log the volunteer registration
            Log::info('Volunteer Registration Submitted', $validated);

            // Redirect volunteer to their dashboard/profile
            return redirect("/volunteer/{$volunteer->id}/dashboard")->with('success', 'Thank you for registering!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }
}
