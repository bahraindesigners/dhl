<?php

use App\Events\EventRegistrationCreated;
use App\Events\EventRegistrationUpdated;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Event as EventFacade;

it('dispatches event registration created event when registration is created', function () {
    EventFacade::fake([EventRegistrationCreated::class]);

    $user = User::factory()->create();
    $eventCategory = EventCategory::factory()->create([
        'receiver_emails' => ['admin@example.com'],
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
    ]);

    EventFacade::assertDispatched(EventRegistrationCreated::class, function ($event) use ($registration) {
        return $event->registration->id === $registration->id;
    });
});

it('dispatches event registration updated event when status changes', function () {
    EventFacade::fake([EventRegistrationUpdated::class]);

    $user = User::factory()->create();
    $eventCategory = EventCategory::factory()->create([
        'receiver_emails' => ['admin@example.com'],
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
    ]);

    // Update the registration status
    $registration->update(['status' => 'confirmed']);

    EventFacade::assertDispatched(EventRegistrationUpdated::class, function ($event) use ($registration) {
        return $event->registration->id === $registration->id &&
            $event->oldStatus === 'pending' &&
            $event->newStatus === 'confirmed';
    });
});

it('does not dispatch event registration updated event when non-status fields change', function () {
    $user = User::factory()->create();
    $eventCategory = EventCategory::factory()->create([
        'receiver_emails' => ['admin@example.com'],
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
    ]);

    EventFacade::fake();

    // Update a non-status field
    $registration->update(['special_requirements' => 'Updated requirements']);

    EventFacade::assertNotDispatched(EventRegistrationUpdated::class);
});

it('can change registration status from pending to confirmed', function () {
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
    ]);

    expect($registration->status)->toBe('pending');
    expect($registration->confirmed_at)->toBeNull();

    // Change status to confirmed
    $registration->update([
        'status' => 'confirmed',
        'confirmed_at' => now(),
    ]);

    expect($registration->fresh()->status)->toBe('confirmed');
    expect($registration->fresh()->confirmed_at)->not->toBeNull();
});
