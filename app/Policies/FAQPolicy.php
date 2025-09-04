<?php

namespace App\Policies;

use App\Models\FAQ;
use App\Models\User;

class FAQPolicy
{
    /**
     * Determine whether the user can view any FAQs.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view faqs');
    }

    /**
     * Determine whether the user can view the FAQ.
     */
    public function view(User $user, FAQ $fAQ): bool
    {
        return $user->can('view faqs');
    }

    /**
     * Determine whether the user can create FAQs.
     */
    public function create(User $user): bool
    {
        return $user->can('create faqs');
    }

    /**
     * Determine whether the user can update the FAQ.
     */
    public function update(User $user, FAQ $fAQ): bool
    {
        return $user->can('edit faqs');
    }

    /**
     * Determine whether the user can delete the FAQ.
     */
    public function delete(User $user, FAQ $fAQ): bool
    {
        return $user->can('delete faqs');
    }

    /**
     * Determine whether the user can restore the FAQ.
     */
    public function restore(User $user, FAQ $fAQ): bool
    {
        return $user->can('restore faqs');
    }

    /**
     * Determine whether the user can permanently delete the FAQ.
     */
    public function forceDelete(User $user, FAQ $fAQ): bool
    {
        return $user->can('force delete faqs');
    }

    /**
     * Determine whether the user can replicate the FAQ.
     */
    public function replicate(User $user, FAQ $fAQ): bool
    {
        return $user->can('replicate faqs');
    }

    /**
     * Determine whether the user can reorder FAQs.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder faqs');
    }
}
