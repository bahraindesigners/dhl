<?php

namespace App\Listeners;

use App\Events\ComplaintUpdated;
use App\Mail\ComplaintUpdatedNotification;
use App\Models\ComplaintSettings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendComplaintUpdatedNotifications implements ShouldQueue
{
    use InteractsWithQueue;
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the listener should be queued.
     */
    public function shouldQueue(): bool
    {
        // Don't queue in testing environment
        return ! app()->environment('testing');
    }

    /**
     * Handle the event.
     */
    public function handle(ComplaintUpdated $event): void
    {
        $settings = ComplaintSettings::current();

        // Check if complaint form is enabled
        if (! $settings->form_enabled) {
            return;
        }

        $complaint = $event->complaint;

        // Send notification to member only if status changed
        if ($complaint->user && $complaint->user->email) {
            Mail::to($complaint->user->email)
                ->send(new ComplaintUpdatedNotification($complaint, false));
        }

        // Send notification to admin emails
        if (! empty($settings->admin_emails)) {
            foreach ($settings->admin_emails as $adminEmail) {
                if (filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($adminEmail)
                        ->send(new ComplaintUpdatedNotification($complaint, true));
                }
            }
        }
    }
}
