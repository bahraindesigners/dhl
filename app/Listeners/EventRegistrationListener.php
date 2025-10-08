<?php

namespace App\Listeners;

use App\Events\EventRegistrationCreated;
use App\Mail\EventRegistrationConfirmation;
use App\Mail\NewRegistrationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EventRegistrationListener implements ShouldQueue
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
    public function handle(EventRegistrationCreated $event): void
    {
        $registration = $event->registration;
        $eventModel = $registration->event;
        $eventCategory = $eventModel->eventCategory;

        $traceId = uniqid('listener_');
        Log::info('EventRegistrationListener handle called', [
            'registration_id' => $registration->id,
            'trace_id' => $traceId,
        ]);

        // Check if the event category has receiver emails
        if (! $eventCategory || empty($eventCategory->receiver_emails)) {
            Log::warning('No receiver emails found for event category', [
                'event_id' => $eventModel->id,
                'event_title' => $eventModel->title,
                'category_id' => $eventCategory?->id,
                'category_name' => $eventCategory?->name,
                'trace_id' => $traceId,
            ]);

            return;
        }

        try {
            // Filter out invalid emails and send notifications
            $validEmails = array_filter($eventCategory->receiver_emails, function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });

            if (empty($validEmails)) {
                Log::warning('No valid receiver emails found for event category', [
                    'event_id' => $eventModel->id,
                    'category_id' => $eventCategory->id,
                    'trace_id' => $traceId,
                ]);

                return;
            }

            // Send email notification to the category receivers
            Mail::to($validEmails)
                ->queue(new NewRegistrationNotification($registration));

            // Send confirmation email to the registrant
            Mail::to($registration->email)
                ->queue(new EventRegistrationConfirmation($registration, $eventModel));

            Log::info('Registration emails queued successfully', [
                'registration_id' => $registration->id,
                'event_id' => $eventModel->id,
                'notification_recipients' => $validEmails,
                'confirmation_recipient' => $registration->email,
                'registrant_name' => $registration->first_name.' '.$registration->last_name,
                'trace_id' => $traceId,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send registration emails', [
                'registration_id' => $registration->id,
                'event_id' => $eventModel->id,
                'notification_recipients' => $validEmails ?? [],
                'confirmation_recipient' => $registration->email,
                'error' => $e->getMessage(),
            ]);

            // Re-throw the exception so the job can be retried
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(EventRegistrationCreated $event, \Throwable $exception): void
    {
        Log::error('EventRegistrationListener job failed', [
            'registration_id' => $event->registration->id,
            'event_id' => $event->registration->event->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
