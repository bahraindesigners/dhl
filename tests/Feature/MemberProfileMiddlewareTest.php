<?php

use App\Models\MemberProfile;
use App\Models\User;

test('authenticated user without member profile is redirected to membership page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect('/membership')
        ->assertSessionHas('info', 'Please complete your member profile to access this feature.');
});

test('authenticated user with member profile can access dashboard', function () {
    $user = User::factory()->create();

    // Create a member profile for the user
    MemberProfile::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
});

test('unauthenticated user is redirected to login', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});

test('user without member profile can still access membership page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/membership');

    $response->assertStatus(200);
});

test('user without member profile is redirected from settings', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/settings/profile');

    $response->assertRedirect('/membership')
        ->assertSessionHas('info', 'Please complete your member profile to access this feature.');
});
