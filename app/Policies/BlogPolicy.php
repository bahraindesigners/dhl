<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    /**
     * Determine whether the user can view any blogs.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view blogs');
    }

    /**
     * Determine whether the user can view the blog.
     */
    public function view(User $user, Blog $blog): bool
    {
        return $user->can('view blogs');
    }

    /**
     * Determine whether the user can create blogs.
     */
    public function create(User $user): bool
    {
        return $user->can('create blogs');
    }

    /**
     * Determine whether the user can update the blog.
     */
    public function update(User $user, Blog $blog): bool
    {
        return $user->can('edit blogs');
    }

    /**
     * Determine whether the user can delete the blog.
     */
    public function delete(User $user, Blog $blog): bool
    {
        return $user->can('delete blogs');
    }

    /**
     * Determine whether the user can restore the blog.
     */
    public function restore(User $user, Blog $blog): bool
    {
        return $user->can('restore blogs');
    }

    /**
     * Determine whether the user can permanently delete the blog.
     */
    public function forceDelete(User $user, Blog $blog): bool
    {
        return $user->can('force delete blogs');
    }

    /**
     * Determine whether the user can replicate the blog.
     */
    public function replicate(User $user, Blog $blog): bool
    {
        return $user->can('replicate blogs');
    }

    /**
     * Determine whether the user can reorder blogs.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder blogs');
    }
}
