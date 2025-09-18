<?php

namespace App\Events;

use App\Models\EventRegistration;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventRegistrationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public EventRegistration $registration;

    /**
     * Create a new event instance.
     */
    public function __construct(EventRegistration $registration)
    {
        $this->registration = $registration;
    }
}
