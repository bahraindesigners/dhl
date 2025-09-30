<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequiresMemberProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check if user has a member profile
            if (! $user->memberProfile || ! $user->memberProfile->profile_status) {
                // If the user is already on the profile page, allow access
                if ($request->routeIs('profile')) {
                    return $next($request);
                }

                // Redirect to profile page with a message
                return redirect()->route('profile')->with('info', 'Please complete your member profile to access this feature.');
            }
        }

        return $next($request);
    }
}
