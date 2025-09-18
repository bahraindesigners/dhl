<?php

namespace App\Policies;

use App\Models\BoardMember;
use App\Models\User;

class BoardMemberPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view board members');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BoardMember $boardMember): bool
    {
        return $user->can('view board members');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create board members');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BoardMember $boardMember): bool
    {
        return $user->can('edit board members');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BoardMember $boardMember): bool
    {
        return $user->can('delete board members');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BoardMember $boardMember): bool
    {
        return $user->can('restore board members');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BoardMember $boardMember): bool
    {
        return $user->can('force delete board members');
    }

    /**
     * Determine whether the user can replicate the board member.
     */
    public function replicate(User $user, BoardMember $boardMember): bool
    {
        return $user->can('replicate board members');
    }

    /**
     * Determine whether the user can reorder board members.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder board members');
    }
}
