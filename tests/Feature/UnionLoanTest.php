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
        'min_amount' => 100.00,
        'max_amount' => 10000.00,
        'min_monthly_payment' => 75.00,
        'receivers' => ['admin@union.com', 'hr@union.com'],
        'is_active' => true,
    ]);

    expect($settings->max_months)->toBe(24);
    expect($settings->min_amount)->toBe('100.00');
    expect($settings->max_amount)->toBe('10000.00');
    expect($settings->min_monthly_payment)->toBe('75.00');
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

it('validates loan settings calculations', function () {
    $settings = UnionLoanSettings::create([
        'max_months' => 24,
        'min_amount' => 100.00,
        'max_amount' => 10000.00,
        'min_monthly_payment' => 75.00,
        'receivers' => ['admin@union.com'],
        'is_active' => true,
    ]);

    // Test valid loan combination
    expect($settings->isValidLoanCombination(1500, 20))->toBeTrue(); // 75 BD/month
    expect($settings->isValidLoanCombination(7500, 24))->toBeTrue(); // 312.50 BD/month

    // Test invalid loan combinations
    expect($settings->isValidLoanCombination(1500, 25))->toBeFalse(); // 60 BD/month < 75
    expect($settings->isValidLoanCombination(50, 12))->toBeFalse(); // Below min amount
    expect($settings->isValidLoanCombination(15000, 12))->toBeFalse(); // Above max amount
    expect($settings->isValidLoanCombination(1000, 30))->toBeFalse(); // Above max months
});

it('calculates monthly payment correctly', function () {
    $settings = UnionLoanSettings::create([
        'max_months' => 24,
        'min_amount' => 100.00,
        'max_amount' => 10000.00,
        'min_monthly_payment' => 75.00,
        'receivers' => ['admin@union.com'],
        'is_active' => true,
    ]);

    expect($settings->calculateMonthlyPayment(1500, 20))->toBe(75.00);
    expect($settings->calculateMonthlyPayment(3000, 12))->toBe(250.00);
    expect($settings->calculateMonthlyPayment(7500, 24))->toBe(312.50);
});

it('calculates max duration for amount correctly', function () {
    $settings = UnionLoanSettings::create([
        'max_months' => 24,
        'min_amount' => 100.00,
        'max_amount' => 10000.00,
        'min_monthly_payment' => 75.00,
        'receivers' => ['admin@union.com'],
        'is_active' => true,
    ]);

    expect($settings->getMaxDurationForAmount(1500))->toBe(20); // 1500 / 75 = 20
    expect($settings->getMaxDurationForAmount(7500))->toBe(24); // 7500 / 75 = 100, but limited by max_months
    expect($settings->getMaxDurationForAmount(750))->toBe(10); // 750 / 75 = 10
});

it('rejects loan application with insufficient monthly payment', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
        'profile_status' => true,
    ]);

    UnionLoanSettings::create([
        'max_months' => 30,
        'min_amount' => 100.00,
        'max_amount' => 10000.00,
        'min_monthly_payment' => 75.00,
        'receivers' => ['admin@union.com'],
        'is_active' => true,
    ]);

    $this->actingAs($user);

    // Try to submit loan with monthly payment below minimum (1500 / 25 = 60 < 75)
    $response = $this->post('/loans', [
        'amount' => 1500,
        'months' => 25,
        'note' => 'Test loan'
    ]);

    $response->assertSessionHasErrors('amount');
});

it('accepts loan application with valid monthly payment', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
        'profile_status' => true,
    ]);

    UnionLoanSettings::create([
        'max_months' => 24,
        'min_amount' => 100.00,
        'max_amount' => 10000.00,
        'min_monthly_payment' => 75.00,
        'receivers' => ['admin@union.com'],
        'is_active' => true,
    ]);

    $this->actingAs($user);

    // Submit loan with valid monthly payment (1500 / 20 = 75)
    $response = $this->post('/loans', [
        'amount' => 1500,
        'months' => 20,
        'note' => 'Test loan'
    ]);

    $response->assertRedirect('/loans');
    $this->assertDatabaseHas('union_loans', [
        'user_id' => $user->id,
        'amount' => 1500,
        'months' => 20,
    ]);
});
