<?php

use App\Models\BoardMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed permissions and roles
    $this->seed(\Database\Seeders\PermissionAndRoleSeeder::class);

    // Create a super admin user for testing
    $this->superAdmin = User::factory()->create();
    $this->superAdmin->assignRole('Super Admin');
});

it('can create a board member', function () {
    $boardMemberData = [
        'name' => 'John Smith',
        'position' => 'Chief Executive Officer',
        'description' => 'John is a visionary leader with over 15 years of experience.',
        'sort_order' => 1,
        'is_active' => true,
    ];

    $boardMember = BoardMember::create($boardMemberData);

    expect($boardMember)->toBeInstanceOf(BoardMember::class);
    expect($boardMember->name)->toBe('John Smith');
    expect($boardMember->position)->toBe('Chief Executive Officer');
    expect($boardMember->is_active)->toBeTrue();
});

it('can update a board member', function () {
    $boardMember = BoardMember::factory()->create([
        'name' => 'Original Name',
        'position' => 'Original Position',
    ]);

    $boardMember->update([
        'name' => 'Updated Name',
        'position' => 'Updated Position',
    ]);

    expect($boardMember->fresh()->name)->toBe('Updated Name');
    expect($boardMember->fresh()->position)->toBe('Updated Position');
});

it('can delete a board member', function () {
    $boardMember = BoardMember::factory()->create();
    $id = $boardMember->id;

    $boardMember->delete();

    expect(BoardMember::find($id))->toBeNull();
});

it('factory creates valid board members', function () {
    $boardMember = BoardMember::factory()->create();

    expect($boardMember->name)->not->toBeEmpty();
    expect($boardMember->position)->not->toBeEmpty();
    expect($boardMember->sort_order)->toBeNumeric();
    expect($boardMember->is_active)->toBeIn([true, false]);
});

it('factory states work correctly', function () {
    $activeMember = BoardMember::factory()->active()->create();
    $inactiveMember = BoardMember::factory()->inactive()->create();
    $chairman = BoardMember::factory()->chairman()->create();
    $ceo = BoardMember::factory()->ceo()->create();

    expect($activeMember->is_active)->toBeTrue();
    expect($inactiveMember->is_active)->toBeFalse();
    expect($chairman->position)->toBe('Chairman');
    expect($chairman->sort_order)->toBe(1);
    expect($ceo->position)->toBe('Chief Executive Officer');
    expect($ceo->sort_order)->toBe(2);
});

it('can query active board members only', function () {
    BoardMember::factory()->active()->count(3)->create();
    BoardMember::factory()->inactive()->count(2)->create();

    $activeMembers = BoardMember::active()->get();

    expect($activeMembers)->toHaveCount(3);
    $activeMembers->each(function ($member) {
        expect($member->is_active)->toBeTrue();
    });
});

it('can order board members correctly', function () {
    BoardMember::factory()->create(['sort_order' => 5, 'name' => 'E']);
    BoardMember::factory()->create(['sort_order' => 1, 'name' => 'A']);
    BoardMember::factory()->create(['sort_order' => 3, 'name' => 'C']);
    BoardMember::factory()->create(['sort_order' => 1, 'name' => 'B']); // Same order, different name

    $orderedMembers = BoardMember::ordered()->get();

    expect($orderedMembers->first()->sort_order)->toBe(1);
    expect($orderedMembers->first()->name)->toBe('A'); // A comes before B alphabetically
    expect($orderedMembers->last()->sort_order)->toBe(5);
});

it('handles media collections correctly', function () {
    $boardMember = BoardMember::factory()->create();

    // Test that media collection is registered
    $collections = $boardMember->getRegisteredMediaCollections();
    $avatarCollection = $collections->where('name', 'avatar')->first();

    expect($avatarCollection)->not->toBeNull();
    expect($avatarCollection->singleFile)->toBeTrue();
});

it('validates required fields through model', function () {
    expect(function () {
        BoardMember::create([
            'position' => 'CEO',
            'description' => 'Test description',
        ]);
    })->toThrow(\Illuminate\Database\QueryException::class);
});

it('has proper resource navigation available', function () {
    expect(\App\Filament\Resources\BoardMembers\BoardMemberResource::getModel())->toBe(BoardMember::class);
    expect(\App\Filament\Resources\BoardMembers\BoardMemberResource::getNavigationIcon())->not->toBeNull();
});
