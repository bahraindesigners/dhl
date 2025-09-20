<?php

namespace App\Listeners;

use App\Events\UnionLoanUpdated;
use App\Mail\UnionLoanStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUnionLoanStatusUpdate implements ShouldQueue
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
    public function handle(UnionLoanUpdated $event): void
    {
        // Check if status update notifications are enabled
        if (! config('loans.notifications.send_status_update_notifications', true)) {
            return;
        }

        // Send status update notification to the user who created the loan
        Mail::to($event->unionLoan->user->email)
            ->send(new UnionLoanStatusUpdated($event->unionLoan));
    }
}
