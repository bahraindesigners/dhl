<?php

use App\LoanStatus;
use App\Models\MemberProfile;
use App\Models\UnionLoan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create a test user
    $this->user = User::factory()->create([
        'name' => 'Mike Johnson',
        'email' => 'mike.johnson@example.com',
    ]);

    // Create a test member profile
    $this->memberProfile = MemberProfile::factory()->create([
        'user_id' => $this->user->id,
        'staff_number' => 'STAFF003',
        'department' => 'Finance',
        'position' => 'Accountant',
    ]);

    // Create a test union loan
    $this->unionLoan = UnionLoan::factory()->create([
        'user_id' => $this->user->id,
        'amount' => 5000.00,
        'months' => 12,
        'status' => LoanStatus::Pending,
        'note' => 'Need loan for home renovation',
    ]);
});

it('can generate a PDF for a union loan', function () {
    $pdf = Pdf::loadView('pdf.union-loan', [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ]);

    $output = $pdf->output();

    expect($output)->toBeString()
        ->and(strlen($output))->toBeGreaterThan(0);
});

it('includes all union loan information in PDF view', function () {
    $viewData = [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.union-loan', $viewData)->render();

    expect($view)->toContain('Mike Johnson')
        ->and($view)->toContain('mike.johnson@example.com')
        ->and($view)->toContain('STAFF003')
        ->and($view)->toContain('Finance')
        ->and($view)->toContain('Accountant')
        ->and($view)->toContain('5,000.00')
        ->and($view)->toContain('12 months');
});

it('includes comprehensive member profile information in PDF', function () {
    $viewData = [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.union-loan', $viewData)->render();

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

it('displays loan status correctly in PDF', function () {
    $viewData = [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.union-loan', $viewData)->render();

    expect($view)->toContain('Pending');
});

it('calculates monthly installment correctly in PDF', function () {
    $monthlyInstallment = $this->unionLoan->amount / $this->unionLoan->months;

    $viewData = [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.union-loan', $viewData)->render();

    expect($view)->toContain(number_format($monthlyInstallment, 2));
});

it('shows loan notes when present in PDF', function () {
    $viewData = [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.union-loan', $viewData)->render();

    expect($view)->toContain('Application Notes')
        ->and($view)->toContain('Need loan for home renovation');
});

it('shows rejection reason when loan is rejected', function () {
    $this->unionLoan->update([
        'status' => LoanStatus::Rejected,
        'rejected_reason' => 'Insufficient employment history.',
    ]);

    $viewData = [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.union-loan', $viewData)->render();

    expect($view)->toContain('Rejection Reason')
        ->and($view)->toContain('Insufficient employment history.');
});

it('handles union loan without member profile gracefully', function () {
    $viewData = [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => null,
    ];

    $view = view('pdf.union-loan', $viewData)->render();

    expect($view)->toBeString()
        ->and(strlen($view))->toBeGreaterThan(0);
});

it('includes generated date in union loan PDF footer', function () {
    $viewData = [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.union-loan', $viewData)->render();

    expect($view)->toContain(now()->format('F d, Y'));
});

it('displays approved status correctly', function () {
    $this->unionLoan->update(['status' => LoanStatus::Approved]);

    $viewData = [
        'unionLoan' => $this->unionLoan,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.union-loan', $viewData)->render();

    expect($view)->toContain('Approved');
});
