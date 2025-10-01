<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('requires employee image when creating member profile', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $this->actingAs($user);

    $memberData = [
        'cpr_number' => '123456789',
        'staff_number' => 'DHL001',
        'nationality' => 'Bahraini',
        'gender' => 'male',
        'marital_status' => 'single',
        'date_of_joining' => '2024-01-01',
        'position' => 'Software Developer',
        'department' => 'IT',
        'section' => 'Development',
        'working_place_address' => '123 Main St',
        'office_phone' => '17123456',
        'education_qualification' => 'Bachelors Degree',
        'mobile_number' => '36123456',
        'home_phone' => '17654321',
        'permanent_address' => '456 Home St',
        'was_previous_member' => 'no',
        // Note: No employee_image provided
    ];

    $response = $this->post('/membership', $memberData);

    $response->assertSessionHasErrors(['employee_image']);
    expect($response->getSession()->get('errors')->get('employee_image')[0])
        ->toBe('Employee image is required.');
});

it('creates member profile with employee image successfully', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $this->actingAs($user);

    $employeeImage = UploadedFile::fake()->image('employee.jpg', 800, 600)->size(1024); // 1MB

    $memberData = [
        'cpr_number' => '123456789',
        'staff_number' => 'DHL001',
        'nationality' => 'Bahraini',
        'gender' => 'male',
        'marital_status' => 'single',
        'date_of_joining' => '2024-01-01',
        'position' => 'Software Developer',
        'department' => 'IT',
        'section' => 'Development',
        'working_place_address' => '123 Main St',
        'office_phone' => '17123456',
        'education_qualification' => 'Bachelors Degree',
        'mobile_number' => '36123456',
        'home_phone' => '17654321',
        'permanent_address' => '456 Home St',
        'was_previous_member' => 'no',
        'employee_image' => $employeeImage,
    ];

    $response = $this->post('/membership', $memberData);

    $response->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseHas('member_profiles', [
        'user_id' => $user->id,
        'cpr_number' => '123456789',
        'staff_number' => 'DHL001',
    ]);

    // Verify employee image was uploaded
    $memberProfile = $user->fresh()->memberProfile;
    expect($memberProfile->getFirstMedia('employee_image'))->not->toBeNull();
});
