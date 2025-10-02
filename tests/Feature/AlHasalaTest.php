<?php

use App\LoanStatus;
use App\Models\AlHasala;
use App\Models\AlHasalaSettings;
use App\Models\MemberProfile;
use App\Models\User;

it('allows authenticated user with member profile to view al hasala index', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->for($user)->create(['profile_status' => true]);

    $settings = AlHasalaSettings::factory()->create(['is_active' => true]);

    $response = $this->actingAs($user)->get('/al-hasala');

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('al-hasala/index')
        ->has('alHasalas')
        ->has('settings')
        ->has('memberProfile')
    );
});

it('allows user to create al hasala application', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->for($user)->create(['profile_status' => true]);

    $settings = AlHasalaSettings::factory()->create([
        'is_active' => true,
        'max_months' => 24,
    ]);

    $alHasalaData = [
        'amount' => 1000,
        'months' => 12,
        'note' => 'Test note for al hasala application',
    ];

    $response = $this->actingAs($user)->post('/al-hasala', $alHasalaData);

    $response->assertRedirect('/al-hasala');
    $response->assertSessionHas('success', 'Al Hasala application submitted successfully.');

    $this->assertDatabaseHas('al_hasalas', [
        'user_id' => $user->id,
        'amount' => 1000,
        'months' => 12,
        'status' => LoanStatus::Pending->value,
        'note' => 'Test note for al hasala application',
    ]);
});

it('validates al hasala application data', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->for($user)->create(['profile_status' => true]);

    $settings = AlHasalaSettings::factory()->create([
        'is_active' => true,
        'max_months' => 24,
    ]);

    $response = $this->actingAs($user)->post('/al-hasala', []);

    $response->assertSessionHasErrors(['amount', 'months']);
});

it('prevents al hasala application when settings are inactive', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->for($user)->create(['profile_status' => true]);

    $settings = AlHasalaSettings::factory()->create(['is_active' => false]);

    $alHasalaData = [
        'amount' => 1000,
        'months' => 12,
        'note' => 'Test note',
    ];

    $response = $this->actingAs($user)->post('/al-hasala', $alHasalaData);

    $response->assertSessionHasErrors(['error']);
    $this->assertDatabaseMissing('al_hasalas', ['user_id' => $user->id]);
});

it('allows user to view their own al hasala application', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->for($user)->create(['profile_status' => true]);

    $alHasala = AlHasala::factory()->for($user)->create();

    $response = $this->actingAs($user)->get("/al-hasala/{$alHasala->id}");

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('al-hasala/show')
        ->has('alHasala')
        ->where('alHasala.id', $alHasala->id)
        ->where('alHasala.user_id', $user->id)
    );
});

it('prevents user from viewing other users al hasala applications', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $memberProfile1 = MemberProfile::factory()->for($user1)->create(['profile_status' => true]);
    $memberProfile2 = MemberProfile::factory()->for($user2)->create(['profile_status' => true]);

    $alHasala = AlHasala::factory()->for($user2)->create();

    $response = $this->actingAs($user1)->get("/al-hasala/{$alHasala->id}");

    $response->assertForbidden();
});

it('redirects guests to login', function () {
    $response = $this->get('/al-hasala');

    $response->assertRedirect('/login');
});
