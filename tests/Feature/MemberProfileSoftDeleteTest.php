<?php

use App\Models\MemberProfile;
use App\Models\User;

test('member profile can be soft deleted', function () {
    // Ensure we have a user for the profile
    $user = User::factory()->create();

    // Create a member profile
    $profile = MemberProfile::factory()->create(['user_id' => $user->id]);

    // Verify it exists
    expect($profile)->toBeInstanceOf(MemberProfile::class);
    expect(MemberProfile::count())->toBe(1);

    // Soft delete the profile
    $profile->delete();

    // Verify it's soft deleted
    expect(MemberProfile::count())->toBe(0);
    expect(MemberProfile::onlyTrashed()->count())->toBe(1);
    expect(MemberProfile::withTrashed()->count())->toBe(1);

    // Verify deleted_at is set
    $profile->refresh();
    expect($profile->deleted_at)->not->toBeNull();
});

test('soft deleted member profile can be restored', function () {
    // Ensure we have a user for the profile
    $user = User::factory()->create();

    // Create and soft delete a member profile
    $profile = MemberProfile::factory()->create(['user_id' => $user->id]);
    $profile->delete();

    // Verify it's soft deleted
    expect(MemberProfile::count())->toBe(0);
    expect(MemberProfile::onlyTrashed()->count())->toBe(1);

    // Restore the profile
    $profile->restore();

    // Verify it's restored
    expect(MemberProfile::count())->toBe(1);
    expect(MemberProfile::onlyTrashed()->count())->toBe(0);

    // Verify deleted_at is null
    $profile->refresh();
    expect($profile->deleted_at)->toBeNull();
});

test('member profile can be force deleted', function () {
    // Ensure we have a user for the profile
    $user = User::factory()->create();

    // Create a member profile
    $profile = MemberProfile::factory()->create(['user_id' => $user->id]);
    $profileId = $profile->id;

    // Force delete the profile
    $profile->forceDelete();

    // Verify it's completely removed
    expect(MemberProfile::count())->toBe(0);
    expect(MemberProfile::withTrashed()->count())->toBe(0);
    expect(MemberProfile::withTrashed()->find($profileId))->toBeNull();
});

test('with trashed includes soft deleted profiles', function () {
    // Ensure we have users for the profiles
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // Create two profiles
    $profile1 = MemberProfile::factory()->create(['user_id' => $user1->id]);
    $profile2 = MemberProfile::factory()->create(['user_id' => $user2->id]);

    // Soft delete one
    $profile1->delete();

    // Verify counts
    expect(MemberProfile::count())->toBe(1); // Only active
    expect(MemberProfile::withTrashed()->count())->toBe(2); // Active + trashed
    expect(MemberProfile::onlyTrashed()->count())->toBe(1); // Only trashed
});
