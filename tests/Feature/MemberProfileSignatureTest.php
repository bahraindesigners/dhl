<?php

use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

it('can attach a signature to a member profile', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);

    // Create a fake image file for testing
    $signatureFile = UploadedFile::fake()->image('signature.png', 400, 200);

    // Add signature to the member profile
    $memberProfile->addMedia($signatureFile->getRealPath())
        ->toMediaCollection('signature');

    // Verify the signature was added
    expect($memberProfile->getMedia('signature'))->toHaveCount(1);
    expect($memberProfile->getFirstMediaUrl('signature'))->not->toBeEmpty();
});

it('can generate signature thumbnail conversion', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);

    // Create a fake image file for testing
    $signatureFile = UploadedFile::fake()->image('signature.png', 400, 200);

    // Add signature to the member profile
    $media = $memberProfile->addMedia($signatureFile->getRealPath())
        ->toMediaCollection('signature');

    // Verify the thumbnail conversion exists
    expect($memberProfile->getFirstMediaUrl('signature', 'signature_thumb'))->not->toBeEmpty();
});

it('enforces single signature per member profile', function () {
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);

    // Add first signature
    $firstSignature = UploadedFile::fake()->image('signature1.png', 400, 200);
    $memberProfile->addMedia($firstSignature->getRealPath())
        ->toMediaCollection('signature');

    expect($memberProfile->getMedia('signature'))->toHaveCount(1);

    // Add second signature - should replace the first
    $secondSignature = UploadedFile::fake()->image('signature2.png', 400, 200);
    $memberProfile->addMedia($secondSignature->getRealPath())
        ->toMediaCollection('signature');

    expect($memberProfile->getMedia('signature'))->toHaveCount(1);
});
