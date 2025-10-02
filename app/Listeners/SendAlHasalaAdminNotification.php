<?php

namespace App\Listeners;

use App\Events\AlHasalaCreated;
use App\Mail\NewAlHasalaNotification;
use App\Models\AlHasalaSettings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAlHasalaAdminNotification
{
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
    public function handle(AlHasalaCreated $event): void
    {
        // Get settings using singleton pattern
        $settings = AlHasalaSettings::getSingleton();
        
        if (!$settings || !$settings->is_active) {
            Log::info('Al Hasala admin notification skipped - settings not active');
            return;
        }

        // Get notification recipients from settings
        $recipients = $settings->receivers ?? [];
        
        if (empty($recipients)) {
            Log::warning('Al Hasala admin notification skipped - no recipients configured');
            return;
        }

        // Send notification to each admin recipient
        foreach ($recipients as $recipient) {
            if (isset($recipient['email']) && filter_var($recipient['email'], FILTER_VALIDATE_EMAIL)) {
                try {
                    Mail::to($recipient['email'])
                        ->send(new NewAlHasalaNotification($event->alHasala));
                    
                    Log::info('Al Hasala admin notification sent', [
                        'al_hasala_id' => $event->alHasala->id,
                        'recipient' => $recipient['email']
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to send Al Hasala admin notification', [
                        'al_hasala_id' => $event->alHasala->id,
                        'recipient' => $recipient['email'],
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                Log::warning('Invalid email address in Al Hasala settings', [
                    'recipient' => $recipient
                ]);
            }
        }
    }
}
