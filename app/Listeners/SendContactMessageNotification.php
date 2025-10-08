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
        if (! config('contact.notifications.send_notifications', true)) {
            Log::info('Contact notifications are disabled in config');

            return;
        }

        // Get notification emails from contact settings
        $settings = ContactSetting::getSingleton();

        $notificationEmails = $settings->notification_emails ?? [];

        if (empty($notificationEmails)) {
            Log::warning('No notification emails configured for contact messages');

            return;
        }

        // Filter out any invalid emails
        $validEmails = array_filter($notificationEmails, function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        // Check if mail is properly configured (not using log/array drivers)
        $mailDriver = config('mail.default');
        $isProductionMailDriver = ! in_array($mailDriver, ['log', 'array']);

        if (! $isProductionMailDriver) {
            Log::warning('Contact notification attempted but mail is not configured for production', [
                'mail_driver' => $mailDriver,
                'contact_id' => $event->contact->id,
                'notification_emails' => $validEmails,
                'message' => 'Email notifications are configured to use log/testing driver. Configure SMTP, Mailgun, SES, or other production mail driver to actually send emails.',
            ]);
        }

        try {
            $mailInstance = Mail::to($validEmails);

            // Check if queuing is enabled in config
            if (config('contact.notifications.queue_enabled', false)) {
                $mailInstance->queue(new NewContactMessage($event->contact));
            } else {
                $mailInstance->send(new NewContactMessage($event->contact));
            }

            Log::info('Contact notification email processed', [
                'contact_id' => $event->contact->id,
                'notification_emails' => $validEmails,
                'email_count' => count($validEmails),
                'mail_driver' => $mailDriver,
                'actually_sent' => $isProductionMailDriver,
                'queued' => config('contact.notifications.queue_enabled', false),
            ]);
        } catch (\Exception $e) {
            // Log the error but don't fail the process
            Log::error('Failed to send contact notification email: '.$e->getMessage(), [
                'contact_id' => $event->contact->id,
                'contact_email' => $event->contact->email,
                'notification_emails' => $validEmails,
            ]);
        }
    }
}
