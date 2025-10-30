<?php

use App\Models\Complaint;
use App\Models\MemberProfile;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create a test user
    $this->user = User::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
    ]);

    // Create a test member profile
    $this->memberProfile = MemberProfile::factory()->create([
        'user_id' => $this->user->id,
        'staff_number' => 'STAFF002',
        'department' => 'HR',
    ]);

    // Create a test complaint
    $this->complaint = Complaint::factory()->create([
        'user_id' => $this->user->id,
        'member_profile_id' => $this->memberProfile->id,
        'ticket_id' => 'CMP-TEST123',
        'subject' => 'Test Complaint Subject',
        'description' => 'This is a detailed complaint description for testing purposes.',
        'status' => 'pending',
        'priority' => 'high',
        'admin_notes' => null,
        'resolved_at' => null,
    ]);
});

it('can generate a PDF for a complaint', function () {
    $pdf = Pdf::loadView('pdf.complaint', [
        'complaint' => $this->complaint,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ]);

    $output = $pdf->output();

    expect($output)->toBeString()
        ->and(strlen($output))->toBeGreaterThan(0);
});

it('includes all complaint information in PDF view', function () {
    $viewData = [
        'complaint' => $this->complaint,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.complaint', $viewData)->render();

    expect($view)->toContain('Jane Smith')
        ->and($view)->toContain('jane.smith@example.com')
        ->and($view)->toContain('CMP-TEST123')
        ->and($view)->toContain('Test Complaint Subject')
        ->and($view)->toContain('This is a detailed complaint description')
        ->and($view)->toContain('STAFF002')
        ->and($view)->toContain('HR');
});

it('includes comprehensive member profile information in PDF', function () {
    $viewData = [
        'complaint' => $this->complaint,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.complaint', $viewData)->render();

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

it('displays complaint status correctly in PDF', function () {
    $viewData = [
        'complaint' => $this->complaint,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.complaint', $viewData)->render();

    expect($view)->toContain('Pending');
});

it('displays complaint priority correctly in PDF', function () {
    $viewData = [
        'complaint' => $this->complaint,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.complaint', $viewData)->render();

    expect($view)->toContain('High');
});

it('shows admin notes when present in complaint PDF', function () {
    $this->complaint->update(['admin_notes' => 'This is an admin note for testing.']);

    $viewData = [
        'complaint' => $this->complaint,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.complaint', $viewData)->render();

    expect($view)->toContain('Administrative Notes')
        ->and($view)->toContain('This is an admin note for testing.');
});

it('shows resolved date when complaint is resolved', function () {
    $resolvedDate = now();
    $this->complaint->update([
        'status' => 'resolved',
        'resolved_at' => $resolvedDate,
    ]);

    $viewData = [
        'complaint' => $this->complaint,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.complaint', $viewData)->render();

    expect($view)->toContain('Resolved On')
        ->and($view)->toContain($resolvedDate->format('F d, Y'));
});

it('handles complaint without member profile gracefully', function () {
    $complaintWithoutProfile = Complaint::factory()->create([
        'user_id' => $this->user->id,
        'member_profile_id' => null,
        'ticket_id' => 'CMP-TEST456',
    ]);

    $viewData = [
        'complaint' => $complaintWithoutProfile,
        'user' => $this->user,
        'memberProfile' => null,
    ];

    $view = view('pdf.complaint', $viewData)->render();

    expect($view)->toBeString()
        ->and(strlen($view))->toBeGreaterThan(0);
});

it('includes generated date in complaint PDF footer', function () {
    $viewData = [
        'complaint' => $this->complaint,
        'user' => $this->user,
        'memberProfile' => $this->memberProfile,
    ];

    $view = view('pdf.complaint', $viewData)->render();

    expect($view)->toContain(now()->format('F d, Y'));
});
