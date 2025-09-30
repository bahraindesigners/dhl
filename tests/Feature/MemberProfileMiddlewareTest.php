<?php

use App\Models\MemberProfile;
use App\Models\User;

test('authenticated user without member profile is redirected to profile page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/loans');

    $response->assertRedirect('/profile')
        ->assertSessionHas('info', 'Please complete your member profile to access this feature.');
});

test('authenticated user with member profile can access loans', function () {
    $user = User::factory()->create();

    // Create an approved member profile for the user
    MemberProfile::factory()->create([
        'user_id' => $user->id,
        'profile_status' => true
    ]);

    $response = $this->actingAs($user)->get('/loans');

    $response->assertStatus(200);
});

test('unauthenticated user is redirected to login', function () {
    $response = $this->get('/loans');

    $response->assertRedirect('/login');
});

test('user without member profile can still access profile page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/profile');

    $response->assertStatus(200);
});

test('user without member profile is redirected from settings', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/settings/profile');

    $response->assertRedirect('/profile')
        ->assertSessionHas('info', 'Please complete your member profile to access this feature.');
});
