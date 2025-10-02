<?php

use App\Mail\ComplaintCreatedNotification;
use App\Models\Complaint;
use App\Models\ComplaintSettings;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('can create complaint settings', function () {
    $settings = ComplaintSettings::current();

    expect($settings)->toBeInstanceOf(ComplaintSettings::class);
    expect($settings->form_enabled)->toBeTrue();
});

it('can submit a complaint when form is enabled', function () {
    Mail::fake();

    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
        'profile_status' => true,  // Ensure profile is complete
    ]);

    // Ensure complaint form is enabled and set admin emails
    $settings = ComplaintSettings::current();
    $settings->update([
        'form_enabled' => true,
        'admin_emails' => ['admin@example.com', 'support@example.com'],
    ]);

    $response = $this->actingAs($user)
        ->post('/complaints', [
            'subject' => 'Test Complaint',
            'description' => 'This is a test complaint description with enough details.',
            'priority' => 'medium',
        ]);

    $response->assertRedirect();

    $complaint = Complaint::where('user_id', $user->id)->first();
    expect($complaint)->not->toBeNull();
    expect($complaint->subject)->toBe('Test Complaint');
    expect($complaint->ticket_id)->toStartWith('CMP-');

    // Assert emails were queued (since they implement ShouldQueue)
    Mail::assertQueued(ComplaintCreatedNotification::class, 3); // 1 to member + 2 to admins
});

it('prevents complaint submission when form is disabled', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
        'profile_status' => true,  // Ensure profile is complete
    ]);

    // Disable complaint form
    $settings = ComplaintSettings::current();
    $settings->update(['form_enabled' => false]);

    $response = $this->actingAs($user)
        ->post('/complaints', [
            'subject' => 'Test Complaint',
            'description' => 'This is a test complaint description with enough details.',
            'priority' => 'medium',
        ]);

    $response->assertRedirect('/');
    $response->assertSessionHas('error');

    expect(Complaint::count())->toBe(0);
});

it('requires member profile to submit complaint', function () {
    $user = User::factory()->create();
    // No member profile created

    $response = $this->actingAs($user)
        ->post('/complaints', [
            'subject' => 'Test Complaint',
            'description' => 'This is a test complaint description with enough details.',
            'priority' => 'medium',
        ]);

    $response->assertRedirect('/profile');
    $response->assertSessionHas('info');
});

it('generates unique ticket IDs', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
        'profile_status' => true,  // Ensure profile is complete
    ]);

    $complaint1 = Complaint::factory()->create([
        'user_id' => $user->id,
        'member_profile_id' => $memberProfile->id,
    ]);

    $complaint2 = Complaint::factory()->create([
        'user_id' => $user->id,
        'member_profile_id' => $memberProfile->id,
    ]);

    expect($complaint1->ticket_id)->not->toBe($complaint2->ticket_id);
    expect($complaint1->ticket_id)->toStartWith('CMP-');
    expect($complaint2->ticket_id)->toStartWith('CMP-');
});
