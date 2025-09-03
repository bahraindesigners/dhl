<?php

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an event', function () {
    $event = Event::factory()->create([
        'title' => 'Test Event',
        'status' => 'published',
        'priority' => 'medium',
    ]);

    expect($event->title)->toBe('Test Event');
    expect($event->status)->toBe('published');
    expect($event->priority)->toBe('medium');
});

it('can register for an event', function () {
    $event = Event::factory()->create([
        'status' => 'published',
        'capacity' => 10,
    ]);

    $user = User::factory()->create();

    $registration = EventRegistration::create([
        'event_id' => $event->id,
        'user_id' => $user->id,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'status' => 'pending',
        'registered_at' => now(),
    ]);

    expect($registration->event_id)->toBe($event->id);
    expect($registration->user_id)->toBe($user->id);
    expect($registration->status)->toBe('pending');
    expect($event->registrations)->toHaveCount(1);
});

it('can check event spots remaining', function () {
    $event = Event::factory()->create([
        'status' => 'published',
        'capacity' => 5,
        'registered_count' => 0,
    ]);

    // Create 3 confirmed registrations
    EventRegistration::factory()->count(3)->create([
        'event_id' => $event->id,
        'status' => 'confirmed',
    ]);

    // Update the registered count manually (in real app, this would be handled by observers/listeners)
    $event->update(['registered_count' => $event->confirmedRegistrations()->count()]);

    expect($event->fresh()->spotsRemaining())->toBe(2);
});
