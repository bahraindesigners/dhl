<?php

namespace App\Listeners;

use App\Events\UnionLoanCreated;
use App\Mail\NewUnionLoanNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewUnionLoanNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UnionLoanCreated $event): void
    {
        // Check if new loan notifications are enabled
        if (! config('loans.notifications.send_new_loan_notifications', true)) {
            return;
        }

        // Get recipient emails from config
        $recipientEmails = config('loans.admin_notification_emails', []);

        if (empty($recipientEmails)) {
            // Fallback to app admin email if no specific config is set
            $recipientEmails = [config('mail.from.address')];
        }

        // Filter out any empty email addresses
        $recipientEmails = array_filter($recipientEmails, function ($email) {
            return ! empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        // Send notification to all valid recipient emails
        foreach ($recipientEmails as $email) {
            Mail::to($email)->send(new NewUnionLoanNotification($event->unionLoan));
        }
    }
}
