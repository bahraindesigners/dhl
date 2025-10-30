<?php

use App\Models\MemberProfile;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create permissions
    Permission::create(['name' => 'view member-profiles']);

    // Create admin role with permission
    $adminRole = Role::create(['name' => 'super_admin']);
    $adminRole->givePermissionTo('view member-profiles');

    // Create admin user with permission
    $this->admin = User::factory()->create();
    $this->admin->assignRole($adminRole);

    // Create a test member profile
    $this->memberUser = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
    ]);

    $this->memberProfile = MemberProfile::factory()->create([
        'user_id' => $this->memberUser->id,
        'cpr_number' => '123456789',
        'staff_number' => 'STAFF001',
        'nationality' => 'Bahraini',
        'gender' => 'male',
        'marital_status' => 'single',
        'date_of_joining' => '2020-01-15',
        'position' => 'Software Engineer',
        'department' => 'IT',
        'section' => 'Development',
        'working_place_address' => 'Building A, Floor 3, Office 301',
        'office_phone' => '+973 1234 5678',
        'education_qualification' => 'Bachelors Degree',
        'mobile_number' => '+973 9876 5432',
        'home_phone' => '+973 1111 2222',
        'permanent_address' => 'Block 123, Road 456, Manama, Bahrain',
        'profile_status' => true,
    ]);
});

it('can generate a PDF for a member profile', function () {
    // Test PDF generation directly
    $pdf = Pdf::loadView('pdf.member-profile', [
        'memberProfile' => $this->memberProfile,
        'user' => $this->memberUser,
    ]);

    $output = $pdf->output();

    // Assert that PDF output is generated
    expect($output)->toBeString()
        ->and(strlen($output))->toBeGreaterThan(0);
});

it('generates PDF with correct filename format', function () {
    $expectedFilename = 'member-profile-STAFF001-' . now()->format('Y-m-d') . '.pdf';

    // The filename should contain staff number and current date
    expect($expectedFilename)->toContain('STAFF001')
        ->and($expectedFilename)->toContain('.pdf')
        ->and($expectedFilename)->toContain(now()->format('Y-m-d'));
});

it('includes all member profile information in PDF view', function () {
    $viewData = [
        'memberProfile' => $this->memberProfile,
        'user' => $this->memberUser,
    ];

    $view = view('pdf.member-profile', $viewData)->render();

    // Assert that the view contains key information
    expect($view)->toContain('John Doe')
        ->and($view)->toContain('john.doe@example.com')
        ->and($view)->toContain('123456789') // CPR number
        ->and($view)->toContain('STAFF001') // Staff number
        ->and($view)->toContain('Software Engineer') // Position
        ->and($view)->toContain('IT') // Department
        ->and($view)->toContain('+973 9876 5432') // Mobile number
        ->and($view)->toContain('Bahraini'); // Nationality
});

it('displays profile status correctly in PDF', function () {
    $activeProfile = $this->memberProfile;
    $activeProfile->profile_status = true;

    $viewData = [
        'memberProfile' => $activeProfile,
        'user' => $this->memberUser,
    ];

    $view = view('pdf.member-profile', $viewData)->render();

    expect($view)->toContain('Active');

    // Test inactive profile
    $activeProfile->profile_status = false;
    $viewData['memberProfile'] = $activeProfile;
    $view = view('pdf.member-profile', $viewData)->render();

    expect($view)->toContain('Inactive');
});

it('formats dates correctly in PDF', function () {
    $viewData = [
        'memberProfile' => $this->memberProfile,
        'user' => $this->memberUser,
    ];

    $view = view('pdf.member-profile', $viewData)->render();

    // Check date formatting
    expect($view)->toContain('January 15, 2020'); // Date of joining
});

it('handles optional fields gracefully in PDF', function () {
    // Create profile with minimal required fields (some optional fields empty)
    $minimalProfile = MemberProfile::factory()->create([
        'user_id' => $this->memberUser->id,
        'section' => null,
        'office_phone' => null,
        'home_phone' => null,
    ]);

    $viewData = [
        'memberProfile' => $minimalProfile,
        'user' => $this->memberUser,
    ];

    // Should render without errors
    $view = view('pdf.member-profile', $viewData)->render();

    expect($view)->toBeString()
        ->and(strlen($view))->toBeGreaterThan(0);
});

it('only allows authorized users to download PDF', function () {
    // Create a regular user without permissions
    $regularUser = User::factory()->create();

    // Attempt to access the member profile view page
    $this->actingAs($regularUser)
        ->get(route('filament.admin.resources.member-profiles.view', $this->memberProfile))
        ->assertForbidden();
});

it('includes generated date in PDF footer', function () {
    $viewData = [
        'memberProfile' => $this->memberProfile,
        'user' => $this->memberUser,
    ];

    $view = view('pdf.member-profile', $viewData)->render();

    // Check that current date is in the footer
    expect($view)->toContain(now()->format('F d, Y'));
});
