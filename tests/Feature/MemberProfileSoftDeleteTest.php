<?php

use App\Models\MemberProfile;

test('member profile can be soft deleted', function () {
    // Create a member profile
    $profile = MemberProfile::factory()->create();
    
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
    // Create and soft delete a member profile
    $profile = MemberProfile::factory()->create();
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
    // Create a member profile
    $profile = MemberProfile::factory()->create();
    $profileId = $profile->id;
    
    // Force delete the profile
    $profile->forceDelete();
    
    // Verify it's completely removed
    expect(MemberProfile::count())->toBe(0);
    expect(MemberProfile::withTrashed()->count())->toBe(0);
    expect(MemberProfile::withTrashed()->find($profileId))->toBeNull();
});

test('with trashed includes soft deleted profiles', function () {
    // Create two profiles
    $profile1 = MemberProfile::factory()->create();
    $profile2 = MemberProfile::factory()->create();
    
    // Soft delete one
    $profile1->delete();
    
    // Verify counts
    expect(MemberProfile::count())->toBe(1); // Only active
    expect(MemberProfile::withTrashed()->count())->toBe(2); // Active + trashed
    expect(MemberProfile::onlyTrashed()->count())->toBe(1); // Only trashed
});
