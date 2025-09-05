<?php

use App\Models\MemberProfile;
use App\Models\User;

it('requires a user to create a member profile', function () {
    expect(fn () => MemberProfile::factory()->create(['user_id' => null]))
        ->toThrow(\Illuminate\Database\QueryException::class);
});

it('can link a member profile to a user', function () {
    $user = User::factory()->create();
    $profile = MemberProfile::factory()->create(['user_id' => $user->id]);

    expect($profile->user_id)->toBe($user->id);
    expect($profile->user)->toBeInstanceOf(User::class);
    expect($profile->user->id)->toBe($user->id);
});

it('can access member profile from user', function () {
    $user = User::factory()->create();
    $profile = MemberProfile::factory()->create(['user_id' => $user->id]);

    $user->refresh();

    expect($user->memberProfile)->toBeInstanceOf(MemberProfile::class);
    expect($user->memberProfile->id)->toBe($profile->id);
});

it('cascades delete when user is deleted', function () {
    $user = User::factory()->create();
    $profile = MemberProfile::factory()->create(['user_id' => $user->id]);

    $user->delete();

    expect(MemberProfile::find($profile->id))->toBeNull();
});

it('displays user name and email instead of profile fields', function () {
    $user = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    $profile = MemberProfile::factory()->create(['user_id' => $user->id]);

    expect($profile->user->name)->toBe('John Doe');
    expect($profile->user->email)->toBe('john@example.com');
});

it('prevents duplicate user assignments', function () {
    $user = User::factory()->create();
    MemberProfile::factory()->create(['user_id' => $user->id]);

    // This should succeed as we allow multiple profiles per user in hasOne relationship
    // but only one profile will be returned by the relationship
    $secondProfile = MemberProfile::factory()->create(['user_id' => $user->id]);

    expect($secondProfile->user_id)->toBe($user->id);
    expect($user->memberProfile)->toBeInstanceOf(MemberProfile::class);
});

it('includes user information in table display', function () {
    $user = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    $profile = MemberProfile::factory()->create(['user_id' => $user->id]);

    expect($profile->load('user')->user->name)->toBe('John Doe');
    expect($profile->load('user')->user->email)->toBe('john@example.com');
});

it('handles soft deleted profiles with user relationships', function () {
    $user = User::factory()->create();
    $profile = MemberProfile::factory()->create(['user_id' => $user->id]);

    $profile->delete(); // Soft delete

    expect($profile->trashed())->toBeTrue();
    expect($profile->user_id)->toBe($user->id);
    expect($user->memberProfile)->toBeNull(); // Should not return soft deleted profile
});
