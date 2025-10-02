<?php

namespace App\Listeners;

use App\Events\ComplaintCreated;
use App\Mail\ComplaintCreatedNotification;
use App\Models\ComplaintSettings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendComplaintCreatedNotifications implements ShouldQueue
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
    public function handle(ComplaintCreated $event): void
    {
        $settings = ComplaintSettings::current();

        // Check if complaint form is enabled
        if (! $settings->form_enabled) {
            return;
        }

        $complaint = $event->complaint;

        // Send notification to member
        if ($complaint->user && $complaint->user->email) {
            Mail::to($complaint->user->email)
                ->send(new ComplaintCreatedNotification($complaint, false));
        }

        // Send notification to admin emails
        if (! empty($settings->admin_emails)) {
            foreach ($settings->admin_emails as $adminEmail) {
                if (filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($adminEmail)
                        ->send(new ComplaintCreatedNotification($complaint, true));
                }
            }
        }
    }
}
