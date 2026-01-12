<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * Middleware to check if the authenticated user has the required role.
     * Usage: ->middleware('role:admin') or ->middleware('role:volunteer')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  The required role (admin or volunteer)
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to continue.');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if user has required role
        if ($user->role !== $role) {
            abort(403, 'Access denied. You do not have permission to access this page.');
        }

        return $next($request);
    }
}
