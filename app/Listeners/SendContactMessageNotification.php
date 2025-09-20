<?php

namespace App\Listeners;

use App\Events\ContactMessageCreated;
use App\Mail\NewContactMessage;
use App\Models\ContactSetting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContactMessageNotification implements ShouldQueue
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
    public function handle(ContactMessageCreated $event): void
    {
        // Check if contact notifications are enabled
        if (!config('contact.notifications.send_notifications', true)) {
            return;
        }

        // Get notification email from contact settings
        $settings = ContactSetting::getSingleton();
        
        if (!$settings->notification_email) {
            Log::warning('No notification email configured for contact messages');
            return;
        }

        try {
            $mailInstance = Mail::to($settings->notification_email);
            
            // Check if queuing is enabled in config
            if (config('contact.notifications.queue_enabled', false)) {
                $mailInstance->queue(new NewContactMessage($event->contact));
            } else {
                $mailInstance->send(new NewContactMessage($event->contact));
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the process
            Log::error('Failed to send contact notification email: ' . $e->getMessage(), [
                'contact_id' => $event->contact->id,
                'contact_email' => $event->contact->email,
                'notification_email' => $settings->notification_email,
            ]);
        }
    }
}
