<?php

use App\Models\User;
use App\Models\MemberProfile;
use App\Models\UnionLoan;
use App\Models\UnionLoanSettings;

it('can access loan index page when authenticated with member profile', function () {
    // Create a user and member profile
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);
    
    // Authenticate the user
    $this->actingAs($user);
    
    // Visit the loans index page
    $response = $this->get('/loans');
    
    $response->assertStatus(200);
});

it('redirects to login when not authenticated', function () {
    $response = $this->get('/loans');
    
    $response->assertRedirect('/login');
});

it('can create loan settings', function () {
    $settings = UnionLoanSettings::create([
        'max_months' => 24,
        'receivers' => ['admin@union.com', 'hr@union.com'],
        'is_active' => true,
    ]);
    
    expect($settings->max_months)->toBe(24);
    expect($settings->receivers)->toBeArray();
    expect($settings->is_active)->toBeTrue();
});

it('can create a union loan', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);
    
    $loan = UnionLoan::create([
        'user_id' => $user->id,
        'amount' => 1000,
        'months' => 12,
        'status' => 'pending',
        'note' => 'Test loan application',
    ]);
    
    expect($loan->amount)->toBe('1000.00');
    expect($loan->months)->toBe(12);
    expect($loan->status->value)->toBe('pending');
    expect($loan->user_id)->toBe($user->id);
});

it('returns member profile through loan relationship', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);
    
    $loan = UnionLoan::create([
        'user_id' => $user->id,
        'amount' => 1000,
        'months' => 12,
        'status' => 'pending',
    ]);
    
    expect($loan->memberProfile)->not->toBeNull();
    expect($loan->memberProfile->id)->toBe($memberProfile->id);
});
