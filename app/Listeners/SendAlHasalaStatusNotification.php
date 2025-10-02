<?php

namespace App\Listeners;

use App\Events\AlHasalaUpdated;
use App\Mail\AlHasalaStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAlHasalaStatusNotification implements ShouldQueue
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
    public function handle(AlHasalaUpdated $event): void
    {
        try {
            // Send status update notification to the applicant
            Mail::to($event->alHasala->user->email)
                ->send(new AlHasalaStatusUpdated($event->alHasala));
            
            Log::info('Al Hasala status notification sent', [
                'al_hasala_id' => $event->alHasala->id,
                'status' => $event->alHasala->status->value,
                'user_email' => $event->alHasala->user->email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send Al Hasala status notification', [
                'al_hasala_id' => $event->alHasala->id,
                'user_email' => $event->alHasala->user->email,
                'error' => $e->getMessage()
            ]);
        }
    }
}