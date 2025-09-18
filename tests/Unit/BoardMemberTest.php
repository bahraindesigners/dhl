<?php

use App\Models\BoardMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

it('can be instantiated', function () {
    $boardMember = new BoardMember;

    expect($boardMember)->toBeInstanceOf(BoardMember::class);
});

it('has correct fillable attributes', function () {
    $expected = [
        'name',
        'position',
        'description',
        'sort_order',
        'is_active',
    ];

    $boardMember = new BoardMember;

    expect($boardMember->getFillable())->toBe($expected);
});

it('has correct casts', function () {
    $boardMember = new BoardMember;

    expect($boardMember->getCasts())->toHaveKey('is_active');
    expect($boardMember->getCasts())->toHaveKey('sort_order');
    expect($boardMember->getCasts()['is_active'])->toBe('boolean');
    expect($boardMember->getCasts()['sort_order'])->toBe('integer');
});

it('can be created with valid data', function () {
    $boardMember = BoardMember::factory()->create([
        'name' => 'John Doe',
        'position' => 'Chairman',
        'description' => 'A seasoned executive with 20 years of experience.',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    expect($boardMember->name)->toBe('John Doe');
    expect($boardMember->position)->toBe('Chairman');
    expect($boardMember->description)->toBe('A seasoned executive with 20 years of experience.');
    expect($boardMember->sort_order)->toBe(1);
    expect($boardMember->is_active)->toBeTrue();
});

it('active scope works', function () {
    BoardMember::factory()->create(['is_active' => true]);
    BoardMember::factory()->create(['is_active' => false]);

    $activeMembers = BoardMember::active()->get();

    expect($activeMembers)->toHaveCount(1);
    expect($activeMembers->first()->is_active)->toBeTrue();
});

it('ordered scope works', function () {
    BoardMember::factory()->create(['sort_order' => 3, 'name' => 'Charlie']);
    BoardMember::factory()->create(['sort_order' => 1, 'name' => 'Alice']);
    BoardMember::factory()->create(['sort_order' => 2, 'name' => 'Bob']);

    $orderedMembers = BoardMember::ordered()->get();

    expect($orderedMembers->first()->name)->toBe('Alice');
    expect($orderedMembers->last()->name)->toBe('Charlie');
});

it('has avatar media collection', function () {
    $boardMember = BoardMember::factory()->create();

    expect($boardMember->getMediaCollection('avatar'))->not->toBeNull();
});

it('can attach avatar media', function () {
    $boardMember = BoardMember::factory()->create();
    $file = UploadedFile::fake()->image('avatar.jpg', 300, 300);

    $boardMember->addMedia($file->getRealPath())
        ->toMediaCollection('avatar');

    expect($boardMember->getMedia('avatar'))->toHaveCount(1);
    expect($boardMember->getFirstMediaUrl('avatar'))->not->toBeEmpty();
});

it('enforces single avatar per board member', function () {
    $boardMember = BoardMember::factory()->create();

    // Add first avatar
    $file1 = UploadedFile::fake()->image('avatar1.jpg', 300, 300);
    $boardMember->addMedia($file1->getRealPath())->toMediaCollection('avatar');

    expect($boardMember->getMedia('avatar'))->toHaveCount(1);

    // Add second avatar - should replace the first
    $file2 = UploadedFile::fake()->image('avatar2.jpg', 300, 300);
    $boardMember->addMedia($file2->getRealPath())->toMediaCollection('avatar');

    expect($boardMember->getMedia('avatar'))->toHaveCount(1);
});

it('generates avatar conversions', function () {
    $boardMember = BoardMember::factory()->create();
    $file = UploadedFile::fake()->image('avatar.jpg', 600, 600);

    $boardMember->addMedia($file->getRealPath())
        ->toMediaCollection('avatar');

    expect($boardMember->getFirstMediaUrl('avatar', 'thumb'))->not->toBeEmpty();
    expect($boardMember->getFirstMediaUrl('avatar', 'medium'))->not->toBeEmpty();
});
