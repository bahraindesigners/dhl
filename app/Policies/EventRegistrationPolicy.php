<?php

namespace App\Policies;

use App\Models\EventRegistration;
use App\Models\User;

class EventRegistrationPolicy
{
    /**
     * Determine whether the user can view any event registrations.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view event registrations');
    }

    /**
     * Determine whether the user can view the event registration.
     */
    public function view(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->can('view event registrations');
    }

    /**
     * Determine whether the user can create event registrations.
     */
    public function create(User $user): bool
    {
        return $user->can('create event registrations');
    }

    /**
     * Determine whether the user can update the event registration.
     */
    public function update(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->can('edit event registrations');
    }

    /**
     * Determine whether the user can delete the event registration.
     */
    public function delete(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->can('delete event registrations');
    }

    /**
     * Determine whether the user can restore the event registration.
     */
    public function restore(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->can('restore event registrations');
    }

    /**
     * Determine whether the user can permanently delete the event registration.
     */
    public function forceDelete(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->can('force delete event registrations');
    }

    /**
     * Determine whether the user can replicate the event registration.
     */
    public function replicate(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->can('replicate event registrations');
    }

    /**
     * Determine whether the user can reorder event registrations.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder event registrations');
    }
}
