<?php

namespace App\Policies;

use App\Models\MemberProfile;
use App\Models\User;

class MemberProfilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_any_member::profile') || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MemberProfile $memberProfile): bool
    {
        return $user->hasPermissionTo('view_member::profile') || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_member::profile') || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MemberProfile $memberProfile): bool
    {
        return $user->hasPermissionTo('update_member::profile') || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MemberProfile $memberProfile): bool
    {
        return $user->hasPermissionTo('delete_member::profile') || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MemberProfile $memberProfile): bool
    {
        return $user->hasPermissionTo('restore_member::profile') || $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MemberProfile $memberProfile): bool
    {
        return $user->hasPermissionTo('force_delete_member::profile') || $user->hasRole('super_admin');
    }
}
