<?php

use App\Mail\EventRegistrationConfirmation;
use App\Mail\NewRegistrationNotification;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('completes full registration workflow with proper status and emails', function () {
    Mail::fake();

    // Create test data - make sure user has member profile
    $user = User::factory()->create();

    // Create member profile for the user (required for registration)
    $memberProfile = \App\Models\MemberProfile::factory()->create([
        'user_id' => $user->id,
        'status' => 'approved',
    ]);

    $eventCategory = EventCategory::factory()->create([
        'receiver_emails' => ['admin@example.com'],
    ]);
    $event = Event::factory()->create([
        'event_category_id' => $eventCategory->id,
        'status' => 'published',
        'registration_enabled' => true,
        'price' => 0,
    ]);

    // Act as the user and register for the event
    $response = $this->actingAs($user)->post(route('events.register', $event), [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'special_requirements' => 'None',
    ]);

    // Should redirect back with success message
    $response->assertRedirect();
    $response->assertSessionHas('success');

    // Check registration was created with pending status
    $registration = $event->registrations()->first();
    expect($registration)->not->toBeNull();
    expect($registration->status)->toBe('pending');
    expect($registration->first_name)->toBe('John');
    expect($registration->last_name)->toBe('Doe');
    expect($registration->email)->toBe('john@example.com');

    // Process any queued jobs
    $this->artisan('queue:work --once --timeout=10');

    // Check that emails were queued for registration creation
    Mail::assertQueued(NewRegistrationNotification::class, function ($mail) use ($eventCategory) {
        return $mail->hasTo($eventCategory->receiver_emails[0]);
    });

    Mail::assertQueued(EventRegistrationConfirmation::class, function ($mail) {
        return $mail->hasTo('john@example.com');
    });

    // Clear mail fake to test status update
    Mail::fake();

    // Simulate admin confirming the registration
    $registration->update([
        'status' => 'confirmed',
        'confirmed_at' => now(),
    ]);

    // Process any queued jobs
    $this->artisan('queue:work --once --timeout=10');

    // Check that confirmation email was sent
    Mail::assertQueued(EventRegistrationConfirmation::class, function ($mail) {
        return $mail->hasTo('john@example.com');
    });

    // Verify final status
    expect($registration->fresh()->status)->toBe('confirmed');
    expect($registration->fresh()->confirmed_at)->not->toBeNull();
});
