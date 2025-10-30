<?php

use App\Mail\NewAlHasalaNotification;
use App\Mail\AlHasalaStatusUpdated;
use App\Mail\NewUnionLoanNotification;
use App\Mail\UnionLoanStatusUpdated;
use App\Models\AlHasala;
use App\Models\AlHasalaSettings;
use App\Models\MemberProfile;
use App\Models\UnionLoan;
use App\Models\UnionLoanSettings;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('renders new union loan notification email', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $memberProfile = MemberProfile::factory()->for($user)->create([
        'staff_number' => 'DHL-12345',
        'department' => 'Operations',
        'mobile_number' => '+973-1234-5678',
    ]);

    UnionLoanSettings::factory()->create();

    $loan = UnionLoan::factory()->for($user)->create([
        'amount' => 5000,
        'months' => 12,
        'status' => 'pending',
        'note' => 'Need loan for home renovation',
    ]);

    $mailable = new NewUnionLoanNotification($loan);

    $rendered = $mailable->render();

    // Check that all key information is present
    expect($rendered)->toContain('New Union Loan Application')
        ->toContain('#' . $loan->id)
        ->toContain('BD 5,000.00')
        ->toContain('12 months')
        ->toContain('John Doe')
        ->toContain('john@example.com')
        ->toContain('DHL-12345')
        ->toContain('Operations')
        ->toContain('Need loan for home renovation');
});

it('renders union loan status updated email', function () {
    $user = User::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    MemberProfile::factory()->for($user)->create();
    UnionLoanSettings::factory()->create();

    $loan = UnionLoan::factory()->for($user)->create([
        'amount' => 3000,
        'months' => 10,
        'status' => 'approved',
    ]);

    $mailable = new UnionLoanStatusUpdated($loan);

    $rendered = $mailable->render();

    // Check that all key information is present
    expect($rendered)->toContain('Union Loan Application Update')
        ->toContain('#' . $loan->id)
        ->toContain('BD 3,000.00')
        ->toContain('10 months')
        ->toContain('Jane Smith');
});

it('renders new al hasala notification email', function () {
    $user = User::factory()->create([
        'name' => 'Ahmed Ali',
        'email' => 'ahmed@example.com',
    ]);

    $memberProfile = MemberProfile::factory()->for($user)->create([
        'staff_number' => 'DHL-67890',
        'department' => 'Finance',
        'mobile_number' => '+973-9876-5432',
    ]);

    AlHasalaSettings::factory()->create();

    $alHasala = AlHasala::factory()->for($user)->create([
        'monthly_amount' => 150,
        'months' => 12,
        'total_amount' => 1800,
        'status' => 'pending',
        'note' => 'Saving for wedding expenses',
    ]);

    $mailable = new NewAlHasalaNotification($alHasala);

    $rendered = $mailable->render();

    // Check that all key information is present
    expect($rendered)->toContain('New Al Hasala Application')
        ->toContain('#' . $alHasala->id)
        ->toContain('Ahmed Ali')
        ->toContain('ahmed@example.com')
        ->toContain('DHL-67890')
        ->toContain('Finance')
        ->toContain('Saving for wedding expenses');

    // Check for monthly amount and total amount (savings plan)
    expect($rendered)->toContain('150')
        ->toContain('1,800');
});

it('renders al hasala status updated email', function () {
    $user = User::factory()->create([
        'name' => 'Sara Hassan',
        'email' => 'sara@example.com',
    ]);

    MemberProfile::factory()->for($user)->create();
    AlHasalaSettings::factory()->create();

    $alHasala = AlHasala::factory()->for($user)->create([
        'monthly_amount' => 100,
        'months' => 24,
        'total_amount' => 2400,
        'status' => 'approved',
    ]);

    $mailable = new AlHasalaStatusUpdated($alHasala);

    $rendered = $mailable->render();

    // Check that all key information is present
    expect($rendered)->toContain('Al Hasala Application Update')
        ->toContain('#' . $alHasala->id)
        ->toContain('Sara Hassan');
});
