<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create and authenticate a basic user
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can create users via factory', function () {
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
    
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@example.com');
    expect($user->exists)->toBeTrue();
});

it('has required fillable fields', function () {
    $user = new User();
    
    expect($user->getFillable())->toContain('name', 'email', 'password');
});

it('hides sensitive attributes', function () {
    $user = User::factory()->make();
    
    expect($user->getHidden())->toContain('password', 'remember_token');
});

it('casts email_verified_at to datetime', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    
    expect($user->email_verified_at)->toBeInstanceOf(\Carbon\Carbon::class);
});

it('uses hexalite role permission trait', function () {
    $user = new User();
    
    // Check that the HexaLiteRolePermission trait is being used
    expect(class_uses($user))->toContain('Hexters\HexaLite\HexaLiteRolePermission');
});

it('can access the user resource navigation', function () {
    // Test basic resource accessibility
    expect(\App\Filament\Resources\Users\UserResource::getModel())->toBe(User::class);
    expect(\App\Filament\Resources\Users\UserResource::getNavigationIcon())->not->toBeNull();
});
