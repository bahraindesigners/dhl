<?php

namespace App\Listeners;

use App\Events\EventRegistrationUpdated;
use App\Mail\EventRegistrationConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EventRegistrationStatusUpdateListener implements ShouldQueue
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
    public function handle(EventRegistrationUpdated $event): void
    {
        $registration = $event->registration;
        $oldStatus = $event->oldStatus;
        $newStatus = $event->newStatus;

        // Only send email if status changed to confirmed
        if ($newStatus === 'confirmed' && $oldStatus !== 'confirmed') {
            try {
                // Send confirmation email to the registrant
                Mail::to($registration->email)
                    ->queue(new EventRegistrationConfirmation($registration, $registration->event));

                Log::info('Registration status update email queued', [
                    'registration_id' => $registration->id,
                    'event_id' => $registration->event->id,
                    'recipient' => $registration->email,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'registrant_name' => $registration->first_name.' '.$registration->last_name,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send registration status update email', [
                    'registration_id' => $registration->id,
                    'event_id' => $registration->event->id,
                    'recipient' => $registration->email,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'error' => $e->getMessage(),
                ]);

                // Re-throw the exception so the job can be retried
                throw $e;
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(EventRegistrationUpdated $event, \Throwable $exception): void
    {
        Log::error('EventRegistrationStatusUpdateListener job failed', [
            'registration_id' => $event->registration->id,
            'event_id' => $event->registration->event->id,
            'old_status' => $event->oldStatus,
            'new_status' => $event->newStatus,
            'error' => $exception->getMessage(),
        ]);
    }
}
