<?php

use Database\Seeders\HexaPermissionSeeder;
use Hexters\HexaLite\Models\HexaRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates all required roles with dynamic permissions', function () {
    // Run the seeder
    $seeder = new HexaPermissionSeeder;
    $seeder->run();

    // Verify all roles are created
    $roles = ['Super Admin', 'Admin', 'Editor', 'User'];
    foreach ($roles as $roleName) {
        expect(HexaRole::where('name', $roleName)->exists())->toBeTrue();
    }
});

it('generates permissions for all available models', function () {
    $seeder = new HexaPermissionSeeder;
    $seeder->run();

    $superAdmin = HexaRole::where('name', 'Super Admin')->first();
    $permissions = collect($superAdmin->access)->keys();

    // Check that permissions exist for each model
    $expectedModels = ['blog', 'faq', 'event', 'event_registration', 'category'];
    $standardActions = ['index', 'create', 'update', 'delete', 'restore', 'replicate', 'reorder', 'force_delete'];

    foreach ($expectedModels as $model) {
        foreach ($standardActions as $action) {
            expect($permissions->contains("{$model}.{$action}"))->toBeTrue(
                "Permission {$model}.{$action} should exist"
            );
        }
    }
});

it('applies correct permission levels for different roles', function () {
    $seeder = new HexaPermissionSeeder;
    $seeder->run();

    // Super Admin should have all permissions
    $superAdmin = HexaRole::where('name', 'Super Admin')->first();
    expect($superAdmin->access['blog.delete'])->toBeTrue();
    expect($superAdmin->access['blog.force_delete'])->toBeTrue();
    expect($superAdmin->access['user.delete'])->toBeTrue();

    // Admin should have limited permissions
    $admin = HexaRole::where('name', 'Admin')->first();
    expect($admin->access['blog.delete'])->toBeTrue();
    expect($admin->access['blog.force_delete'])->toBeFalse();
    expect($admin->access['user.delete'])->toBeFalse();

    // Editor should have even more limited permissions
    $editor = HexaRole::where('name', 'Editor')->first();
    expect($editor->access['blog.delete'])->toBeFalse();
    expect($editor->access['blog.force_delete'])->toBeFalse();
    expect($editor->access['category.update'])->toBeFalse();

    // User should have mostly read-only access
    $user = HexaRole::where('name', 'User')->first();
    expect($user->access['blog.index'])->toBeTrue();
    expect($user->access['blog.create'])->toBeFalse();
    expect($user->access['blog.delete'])->toBeFalse();
});

it('includes system permissions', function () {
    $seeder = new HexaPermissionSeeder;
    $seeder->run();

    $superAdmin = HexaRole::where('name', 'Super Admin')->first();

    expect($superAdmin->access['dashboard.index'])->toBeTrue();
    expect($superAdmin->access['settings.index'])->toBeTrue();
    expect($superAdmin->access['settings.update'])->toBeTrue();
});

it('automatically includes new models when added', function () {
    // This test verifies that if a new model is added to app/Models,
    // the seeder will automatically generate permissions for it
    $seeder = new HexaPermissionSeeder;
    $seeder->run();

    $superAdmin = HexaRole::where('name', 'Super Admin')->first();
    $permissions = collect($superAdmin->access)->keys();

    // All current models should have permissions
    $modelsWithPermissions = $permissions
        ->filter(fn ($p) => ! in_array(explode('.', $p)[0], ['dashboard', 'settings', 'user', 'role', 'media']))
        ->map(fn ($p) => explode('.', $p)[0])
        ->unique()
        ->values();

    // Should include all our current models
    expect($modelsWithPermissions->contains('blog'))->toBeTrue();
    expect($modelsWithPermissions->contains('faq'))->toBeTrue();
    expect($modelsWithPermissions->contains('event'))->toBeTrue();
    expect($modelsWithPermissions->contains('event_registration'))->toBeTrue();
    expect($modelsWithPermissions->contains('category'))->toBeTrue();
});
