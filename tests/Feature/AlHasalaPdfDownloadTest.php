<?php

use App\LoanStatus;
use App\Models\AlHasala;
use App\Models\MemberProfile;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create a test user
    $this->user = User::factory()->create([
        'name' => 'Sarah Williams',
        'email' => 'sarah.williams@example.com',
    ]);

    // Create a test member profile
    $this->memberProfile = MemberProfile::factory()->create([
        'user_id' => $this->user->id,
        'staff_number' => 'STAFF004',
        'department' => 'Operations',
        'position' => 'Manager',
    ]);

    // Create a test al hasala
    $this->alHasala = AlHasala::factory()->create([
        'user_id' => $this->user->id,
        'monthly_amount' => 100.00,
        'months' => 24,
        'total_amount' => 2400.00,
        'status' => LoanStatus::Pending,
        'note' => 'Saving for future investment',
    ]);
});

it('can generate a PDF for al hasala', function () {
    $pdf = Pdf::loadView('pdf.al-hasala', [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ]);

    $output = $pdf->output();

    expect($output)->toBeString()
        ->and(strlen($output))->toBeGreaterThan(0);
});

it('includes all al hasala information in PDF view', function () {
    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    expect($view)->toContain('Sarah Williams')
        ->and($view)->toContain('sarah.williams@example.com')
        ->and($view)->toContain('STAFF004')
        ->and($view)->toContain('Operations')
        ->and($view)->toContain('Manager')
        ->and($view)->toContain('100.00')
        ->and($view)->toContain('24 months')
        ->and($view)->toContain('2,400.00');
});

it('includes comprehensive member profile information in PDF', function () {
    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    // Check for personal information
    expect($view)->toContain($this->memberProfile->cpr_number)
        ->and($view)->toContain($this->memberProfile->nationality)
        ->and($view)->toContain(ucfirst($this->memberProfile->gender))
        ->and($view)->toContain(ucfirst($this->memberProfile->marital_status))
        ->and($view)->toContain($this->memberProfile->mobile_number)
        ->and($view)->toContain($this->memberProfile->permanent_address)
        ->and($view)->toContain($this->memberProfile->working_place_address)
        ->and($view)->toContain($this->memberProfile->education_qualification);
});

it('displays al hasala status correctly in PDF', function () {
    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    expect($view)->toContain('Pending');
});

it('displays monthly and total amounts correctly in PDF', function () {
    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    expect($view)->toContain('BHD 100.00') // Monthly amount
        ->and($view)->toContain('BHD 2,400.00'); // Total amount
});

it('shows al hasala notes when present in PDF', function () {
    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    expect($view)->toContain('Application Notes')
        ->and($view)->toContain('Saving for future investment');
});

it('shows rejection reason when al hasala is rejected', function () {
    $this->alHasala->update([
        'status' => LoanStatus::Rejected,
        'rejected_reason' => 'Does not meet minimum requirements.',
    ]);

    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    expect($view)->toContain('Rejection Reason')
        ->and($view)->toContain('Does not meet minimum requirements.');
});

it('handles al hasala without member profile gracefully', function () {
    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => null,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    expect($view)->toBeString()
        ->and(strlen($view))->toBeGreaterThan(0);
});

it('includes generated date in al hasala PDF footer', function () {
    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    expect($view)->toContain(now()->format('F d, Y'));
});

it('displays approved status correctly', function () {
    $this->alHasala->update(['status' => LoanStatus::Approved]);

    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    expect($view)->toContain('Approved');
});

it('calculates total correctly based on monthly amount and months', function () {
    $expectedTotal = $this->alHasala->monthly_amount * $this->alHasala->months;

    expect((float) $this->alHasala->total_amount)->toBe((float) $expectedTotal);

    $viewData = [
        'alHasala' => $this->alHasala,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.al-hasala', $viewData)->render();

    expect($view)->toContain(number_format($expectedTotal, 2));
});
