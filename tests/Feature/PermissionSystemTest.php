<?php

use App\Models\User;
use Hexters\HexaLite\Models\HexaRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    // Create basic roles with Hexa Lite
    HexaRole::create([
        'name' => 'Super Admin',
        'guard' => 'web',
        'access' => [
            'user.index' => true,
            'user.create' => true,
            'user.update' => true,
            'user.delete' => true,
            'role.index' => true,
            'role.create' => true,
            'role.update' => true,
            'role.delete' => true,
            'dashboard.index' => true,
            'faq.index' => true,
            'faq.create' => true,
            'faq.update' => true,
        ]
    ]);

    HexaRole::create([
        'name' => 'Admin',
        'guard' => 'web',
        'access' => [
            'user.index' => true,
            'user.create' => true,
            'user.update' => true,
            'role.index' => true,
            'dashboard.index' => true,
            'faq.index' => true,
            'faq.create' => true,
            'faq.update' => true,
        ]
    ]);

    HexaRole::create([
        'name' => 'Editor',
        'guard' => 'web',
        'access' => [
            'dashboard.index' => true,
            'faq.index' => true,
            'faq.create' => true,
            'faq.update' => true,
        ]
    ]);

    HexaRole::create([
        'name' => 'User',
        'guard' => 'web',
        'access' => [
            'dashboard.index' => true,
            'faq.index' => true,
        ]
    ]);
});

it('can create and assign roles and permissions', function () {
    // Create a test role with permissions
    $role = HexaRole::create([
        'name' => 'Test Role',
        'guard' => 'web',
        'access' => [
            'test.permission' => true,
        ]
    ]);

    // Create a user and assign the role using database
    $user = User::factory()->create();
    DB::table('hexa_role_user')->insert([
        'role_id' => $role->id,
        'user_id' => $user->id,
    ]);

    // Test the role exists and user is assigned
    expect(HexaRole::where('name', 'Test Role')->exists())->toBeTrue();
    expect($user->roles()->where('name', 'Test Role')->exists())->toBeTrue();
    
    // Check the access array contains the permission
    $roleAccess = $role->fresh()->access;
    expect($roleAccess['test.permission'])->toBeTrue();
});

it('super admin has all permissions', function () {
    // Get the Super Admin role
    $superAdminRole = HexaRole::where('name', 'Super Admin')->first();

    expect($superAdminRole)->not->toBeNull();

    // Create a user and assign Super Admin role
    $user = User::factory()->create();
    DB::table('hexa_role_user')->insert([
        'role_id' => $superAdminRole->id,
        'user_id' => $user->id,
    ]);

    // Test that Super Admin role has comprehensive permissions
    expect($user->roles()->where('name', 'Super Admin')->exists())->toBeTrue();
    
    $access = $superAdminRole->access;
    expect($access['user.index'])->toBeTrue();
    expect($access['user.create'])->toBeTrue();
    expect($access['user.update'])->toBeTrue();
    expect($access['user.delete'])->toBeTrue();
    expect($access['role.index'])->toBeTrue();
    expect($access['role.create'])->toBeTrue();
    expect($access['role.update'])->toBeTrue();
    expect($access['role.delete'])->toBeTrue();
});

it('regular user has limited permissions', function () {
    // Get the User role
    $userRole = HexaRole::where('name', 'User')->first();

    expect($userRole)->not->toBeNull();

    // Create a user and assign User role
    $user = User::factory()->create();
    DB::table('hexa_role_user')->insert([
        'role_id' => $userRole->id,
        'user_id' => $user->id,
    ]);

    // Test that User has limited permissions
    expect($user->roles()->where('name', 'User')->exists())->toBeTrue();
    
    $access = $userRole->access;
    expect($access['dashboard.index'])->toBeTrue();
    expect($access['faq.index'])->toBeTrue();

    // Test that User cannot manage users or roles (these keys shouldn't exist or be false)
    expect($access['user.create'] ?? false)->toBeFalse();
    expect($access['user.update'] ?? false)->toBeFalse();
    expect($access['user.delete'] ?? false)->toBeFalse();
    expect($access['role.create'] ?? false)->toBeFalse();
    expect($access['role.update'] ?? false)->toBeFalse();
    expect($access['role.delete'] ?? false)->toBeFalse();
});

it('editor has content management permissions', function () {
    // Get the Editor role
    $editorRole = HexaRole::where('name', 'Editor')->first();

    expect($editorRole)->not->toBeNull();

    // Create a user and assign Editor role
    $user = User::factory()->create();
    DB::table('hexa_role_user')->insert([
        'role_id' => $editorRole->id,
        'user_id' => $user->id,
    ]);

    // Test that Editor has content permissions
    expect($user->roles()->where('name', 'Editor')->exists())->toBeTrue();
    
    $access = $editorRole->access;
    expect($access['dashboard.index'])->toBeTrue();
    expect($access['faq.index'])->toBeTrue();
    expect($access['faq.create'])->toBeTrue();
    expect($access['faq.update'])->toBeTrue();

    // Test that Editor cannot manage users (these keys shouldn't exist or be false)
    expect($access['user.create'] ?? false)->toBeFalse();
    expect($access['user.update'] ?? false)->toBeFalse();
    expect($access['user.delete'] ?? false)->toBeFalse();
});
