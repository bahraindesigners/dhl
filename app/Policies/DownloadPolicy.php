<?php

namespace App\Policies;

use App\Models\Download;
use App\Models\User;

class DownloadPolicy
{
    /**
     * Determine whether the user can view any downloads.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view downloads');
    }

    /**
     * Determine whether the user can view the download.
     */
    public function view(User $user, Download $download): bool
    {
        return $user->can('view downloads');
    }

    /**
     * Determine whether the user can create downloads.
     */
    public function create(User $user): bool
    {
        return $user->can('create downloads');
    }

    /**
     * Determine whether the user can update the download.
     */
    public function update(User $user, Download $download): bool
    {
        return $user->can('edit downloads');
    }

    /**
     * Determine whether the user can delete the download.
     */
    public function delete(User $user, Download $download): bool
    {
        return $user->can('delete downloads');
    }

    /**
     * Determine whether the user can restore the download.
     */
    public function restore(User $user, Download $download): bool
    {
        return $user->can('delete downloads');
    }

    /**
     * Determine whether the user can permanently delete the download.
     */
    public function forceDelete(User $user, Download $download): bool
    {
        return $user->can('delete downloads');
    }

    /**
     * Determine whether the user can download the file based on access level.
     */
    public function download(User $user, Download $download): bool
    {
        // Check if download is active
        if (! $download->is_active) {
            return false;
        }

        // Check access level permissions
        return match ($download->access_level) {
            'public' => true,
            'employees' => $user->hasRole(['Employee', 'Manager', 'Admin']),
            'managers' => $user->hasRole(['Manager', 'Admin']),
            'admin' => $user->hasRole('Admin'),
            default => false,
        };
    }
}
