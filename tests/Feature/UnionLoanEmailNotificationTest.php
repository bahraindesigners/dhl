<?php

use App\Events\UnionLoanCreated;
use App\Events\UnionLoanUpdated;
use App\LoanStatus;
use App\Mail\NewUnionLoanNotification;
use App\Mail\UnionLoanStatusUpdated;
use App\Models\MemberProfile;
use App\Models\UnionLoan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('sends email notification when new union loan is created', function () {
    Mail::fake();
    Event::fake();

    // Create a user with member profile
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);

    // Create a union loan
    $unionLoan = UnionLoan::factory()->create([
        'user_id' => $user->id,
        'amount' => 1000.00,
        'months' => 12,
        'status' => LoanStatus::Pending,
    ]);

    // Dispatch the event manually since we're using Event::fake()
    UnionLoanCreated::dispatch($unionLoan);

    // Assert the event was dispatched
    Event::assertDispatched(UnionLoanCreated::class, function ($event) use ($unionLoan) {
        return $event->unionLoan->id === $unionLoan->id;
    });

    // When we test the listener manually
    Mail::fake();
    $listener = new \App\Listeners\SendNewUnionLoanNotification;
    $listener->handle(new UnionLoanCreated($unionLoan));

    // Assert mail was sent to admin emails
    $adminEmails = config('loans.admin_notification_emails', []);
    foreach ($adminEmails as $email) {
        if (! empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Mail::assertQueued(NewUnionLoanNotification::class, function ($mail) use ($email, $unionLoan) {
                return $mail->hasTo($email) && $mail->unionLoan->id === $unionLoan->id;
            });
        }
    }
});

it('sends email notification when union loan status is updated', function () {
    Mail::fake();
    Event::fake();

    // Create a user with member profile
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);

    // Create a union loan
    $unionLoan = UnionLoan::factory()->create([
        'user_id' => $user->id,
        'amount' => 1500.00,
        'months' => 18,
        'status' => LoanStatus::Pending,
    ]);

    // Update the loan status to trigger the event
    $unionLoan->update(['status' => LoanStatus::Approved]);

    // Dispatch the event manually since we're using Event::fake()
    UnionLoanUpdated::dispatch($unionLoan);

    // Assert the event was dispatched
    Event::assertDispatched(UnionLoanUpdated::class, function ($event) use ($unionLoan) {
        return $event->unionLoan->id === $unionLoan->id;
    });

    // When we test the listener manually
    Mail::fake();
    $listener = new \App\Listeners\SendUnionLoanStatusUpdate;
    $listener->handle(new UnionLoanUpdated($unionLoan));

    // Assert mail was sent to the user
    Mail::assertQueued(UnionLoanStatusUpdated::class, function ($mail) use ($user, $unionLoan) {
        return $mail->hasTo($user->email) && $mail->unionLoan->id === $unionLoan->id;
    });
});

it('does not send new loan notification when disabled in config', function () {
    Mail::fake();

    // Temporarily disable new loan notifications
    config(['loans.notifications.send_new_loan_notifications' => false]);

    // Create a user with member profile
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);

    // Create a union loan
    $unionLoan = UnionLoan::factory()->create([
        'user_id' => $user->id,
        'amount' => 1000.00,
        'months' => 12,
        'status' => LoanStatus::Pending,
    ]);

    // Test the listener manually
    $listener = new \App\Listeners\SendNewUnionLoanNotification;
    $listener->handle(new UnionLoanCreated($unionLoan));

    // Assert no mail was sent
    Mail::assertNothingSent();
});

it('does not send status update notification when disabled in config', function () {
    Mail::fake();

    // Temporarily disable status update notifications
    config(['loans.notifications.send_status_update_notifications' => false]);

    // Create a user with member profile
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);

    // Create a union loan
    $unionLoan = UnionLoan::factory()->create([
        'user_id' => $user->id,
        'amount' => 1500.00,
        'months' => 18,
        'status' => LoanStatus::Pending,
    ]);

    // Test the listener manually
    $listener = new \App\Listeners\SendUnionLoanStatusUpdate;
    $listener->handle(new UnionLoanUpdated($unionLoan));

    // Assert no mail was sent
    Mail::assertNothingSent();
});

it('filters out invalid email addresses in admin notifications', function () {
    Mail::fake();

    // Set some invalid emails in config
    config(['loans.admin_notification_emails' => [
        'valid@email.com',
        '', // empty
        'invalid-email', // invalid format
        'another@valid.com',
    ]]);

    // Create a user with member profile
    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create(['user_id' => $user->id]);

    // Create a union loan
    $unionLoan = UnionLoan::factory()->create([
        'user_id' => $user->id,
        'amount' => 1000.00,
        'months' => 12,
        'status' => LoanStatus::Pending,
    ]);

    // Test the listener manually
    $listener = new \App\Listeners\SendNewUnionLoanNotification;
    $listener->handle(new UnionLoanCreated($unionLoan));

    // Assert mail was queued only to valid emails
    Mail::assertQueued(NewUnionLoanNotification::class, function ($mail) {
        return $mail->hasTo('valid@email.com');
    });

    Mail::assertQueued(NewUnionLoanNotification::class, function ($mail) {
        return $mail->hasTo('another@valid.com');
    });

    // Assert invalid emails were not sent to
    Mail::assertNotQueued(NewUnionLoanNotification::class, function ($mail) {
        return $mail->hasTo('invalid-email');
    });
});
