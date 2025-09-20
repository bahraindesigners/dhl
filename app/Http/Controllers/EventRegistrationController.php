<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRegistrationRequest;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EventRegistrationController extends Controller
{
    /**
     * Store a new event registration
     */
    public function store(EventRegistrationRequest $request, Event $event)
    {
        $user = Auth::user();

        // Check if user has a member profile
        if (! $user->activeMemberProfile) {
            return back()->with('error', 'You must have a complete member profile to register for events. Please update your profile first.');
        }

        // Check if event allows registration
        if (! $event->canRegister()) {
            return back()->with('error', 'Registration is not available for this event.');
        }

        // Check if user is already registered
        $existingRegistration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'You are already registered for this event.');
        }

        try {
            DB::transaction(function () use ($event, $request, $user) {
                // Create the registration
                $registration = EventRegistration::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'special_requirements' => $request->special_requirements,
                    'status' => 'confirmed', // Auto-confirm for now
                    'registered_at' => now(),
                    'confirmed_at' => now(),
                    'amount_paid' => $event->price ?? 0,
                    'payment_status' => $event->price > 0 ? 'pending' : 'paid',
                ]);

                // Update event registered count
                $event->increment('registered_count');
            });

            return back()->with('success', __('Congratulations! You have been successfully registered for this event. We look forward to seeing you there!'));

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }

    /**
     * Show registration details for a user
     */
    public function show(Event $event, EventRegistration $registration)
    {
        // Ensure the user can view this registration
        if (Auth::check() && $registration->user_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('Event/Registration', [
            'event' => $event,
            'registration' => $registration,
        ]);
    }

    /**
     * Cancel a registration
     */
    public function destroy(Event $event, EventRegistration $registration)
    {
        // Ensure the user can cancel this registration
        if (Auth::check() && $registration->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            DB::transaction(function () use ($event, $registration) {
                $registration->markAsCancelled();
                $event->decrement('registered_count');
            });

            return back()->with('success', 'Your registration has been cancelled.');

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while cancelling your registration.');
        }
    }
}
