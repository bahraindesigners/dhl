<?php

use App\Mail\EventRegistrationConfirmation;
use App\Mail\NewRegistrationNotification;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('sends emails when new registration is created', function () {
    Mail::fake();

    $user = User::factory()->create();
    $eventCategory = EventCategory::factory()->create([
        'receiver_emails' => ['admin@example.com', 'admin2@example.com'],
    ]);
    $event = Event::factory()->create([
        'event_category_id' => $eventCategory->id,
        'status' => 'published',
        'registration_enabled' => true,
    ]);

    $registration = EventRegistration::factory()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'status' => 'pending',
        'email' => 'user@example.com',
    ]);

    // Give time for any queued jobs to process
    $this->artisan('queue:work --once --timeout=10');

    // Check that admin notification was queued
    Mail::assertQueued(NewRegistrationNotification::class, function ($mail) use ($eventCategory) {
        return $mail->hasTo($eventCategory->receiver_emails[0]);
    });

    // Check that user confirmation was queued
    Mail::assertQueued(EventRegistrationConfirmation::class, function ($mail) use ($registration) {
        return $mail->hasTo($registration->email);
    });
});

it('sends confirmation email when registration status changes to confirmed', function () {
    Mail::fake();

    $user = User::factory()->create();
    $eventCategory = EventCategory::factory()->create([
        'receiver_emails' => ['admin@example.com'],
    ]);
    $event = Event::factory()->create([
        'event_category_id' => $eventCategory->id,
        'status' => 'published',
        'registration_enabled' => true,
    ]);

    $registration = EventRegistration::factory()->pending()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'email' => 'user@example.com',
    ]);

    // Clear any mails from creation
    Mail::fake();

    // Update status to confirmed
    $registration->update([
        'status' => 'confirmed',
        'confirmed_at' => now(),
    ]);

    // Give time for any queued jobs to process
    $this->artisan('queue:work --once --timeout=10');

    // Check that confirmation email was sent
    Mail::assertQueued(EventRegistrationConfirmation::class, function ($mail) use ($registration) {
        return $mail->hasTo($registration->email);
    });
});

it('does not send email when status changes to something other than confirmed', function () {
    Mail::fake();

    $user = User::factory()->create();
    $eventCategory = EventCategory::factory()->create([
        'receiver_emails' => ['admin@example.com'],
    ]);
    $event = Event::factory()->create([
        'event_category_id' => $eventCategory->id,
        'status' => 'published',
        'registration_enabled' => true,
    ]);

    $registration = EventRegistration::factory()->pending()->create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'email' => 'user@example.com',
    ]);

    // Clear any mails from creation
    Mail::fake();

    // Update status to cancelled (not confirmed)
    $registration->update([
        'status' => 'cancelled',
        'cancelled_at' => now(),
    ]);

    // Give time for any queued jobs to process
    $this->artisan('queue:work --once --timeout=10');

    // Should not have sent any emails
    Mail::assertNothingQueued();
});
