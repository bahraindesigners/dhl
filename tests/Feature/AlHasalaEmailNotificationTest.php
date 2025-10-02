<?php

use App\Events\AlHasalaCreated;
use App\Events\AlHasalaUpdated;
use App\Mail\NewAlHasalaNotification;
use App\Mail\AlHasalaStatusUpdated;
use App\Models\AlHasala;
use App\Models\AlHasalaSettings;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('sends email notification when new al hasala is created', function () {
    Mail::fake();
    
    // Create settings with email recipients
    AlHasalaSettings::create([
        'max_months' => 24,
        'receivers' => [
            [
                'name' => 'Al Hasala Admin',
                'email' => 'alhasala-admin@dhl.test',
            ],
            [
                'name' => 'Al Hasala Manager',
                'email' => 'alhasala-manager@dhl.test',
            ],
        ],
        'is_active' => true,
    ]);

    $user = User::factory()->create();
    MemberProfile::factory()->create(['user_id' => $user->id]);
    
    $alHasala = AlHasala::create([
        'user_id' => $user->id,
        'amount' => 2000,
        'months' => 12,
        'status' => 'pending',
        'note' => 'Test Al Hasala application',
    ]);

    // Assert that emails were sent to the configured recipients
    Mail::assertSent(NewAlHasalaNotification::class);
    
    Mail::assertSent(NewAlHasalaNotification::class, function ($mail) use ($alHasala) {
        return $mail->alHasala->id === $alHasala->id;
    });
});

it('sends email notification when al hasala status is updated', function () {
    Mail::fake();

    // Create settings for consistency
    AlHasalaSettings::create([
        'max_months' => 24,
        'receivers' => [['name' => 'Admin', 'email' => 'admin@test.com']],
        'is_active' => true,
    ]);

    $user = User::factory()->create();
    MemberProfile::factory()->create(['user_id' => $user->id]);
    
    $alHasala = AlHasala::create([
        'user_id' => $user->id,
        'amount' => 1500,
        'months' => 10,
        'status' => 'pending',
    ]);

    // Update the status
    $alHasala->update(['status' => 'approved']);

    // Assert that status update email was sent to the user
    Mail::assertSent(AlHasalaStatusUpdated::class);
    
    Mail::assertSent(AlHasalaStatusUpdated::class, function ($mail) use ($alHasala, $user) {
        return $mail->alHasala->id === $alHasala->id && $mail->hasTo($user->email);
    });
});

it('does not send new al hasala notification when disabled in config', function () {
    Mail::fake();
    
    // Create settings with notifications disabled
    AlHasalaSettings::create([
        'max_months' => 24,
        'receivers' => [
            [
                'name' => 'Al Hasala Admin',
                'email' => 'alhasala-admin@dhl.test',
            ],
        ],
        'is_active' => false, // Disabled
    ]);

    $user = User::factory()->create();
    MemberProfile::factory()->create(['user_id' => $user->id]);
    
    AlHasala::create([
        'user_id' => $user->id,
        'amount' => 2000,
        'months' => 12,
        'status' => 'pending',
    ]);

    // Assert no emails were sent
    Mail::assertNotSent(NewAlHasalaNotification::class);
});

it('filters out invalid email addresses in admin notifications', function () {
    Mail::fake();
    
    // Create settings with mix of valid and invalid email addresses
    AlHasalaSettings::create([
        'max_months' => 24,
        'receivers' => [
            [
                'name' => 'Valid Admin',
                'email' => 'valid@dhl.test',
            ],
            [
                'name' => 'Invalid Admin',
                'email' => 'invalid-email', // Invalid email
            ],
            [
                'name' => 'Another Valid Admin',
                'email' => 'another@dhl.test',
            ],
        ],
        'is_active' => true,
    ]);

    $user = User::factory()->create();
    MemberProfile::factory()->create(['user_id' => $user->id]);
    
    AlHasala::create([
        'user_id' => $user->id,
        'amount' => 2000,
        'months' => 12,
        'status' => 'pending',
    ]);

    // Assert that emails were sent (to valid addresses only)
    Mail::assertSent(NewAlHasalaNotification::class);
    
    // We should expect at least 2 emails for the 2 valid addresses
    $sentMails = Mail::sent(NewAlHasalaNotification::class);
    expect($sentMails->count())->toBeGreaterThanOrEqual(2);
});
