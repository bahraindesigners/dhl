<?php

namespace App\Policies;

use App\Models\BlogCategory;
use App\Models\User;

class BlogCategoryPolicy
{
    /**
     * Determine whether the user can view any blog categories.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view blog categories');
    }

    /**
     * Determine whether the user can view the blog category.
     */
    public function view(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('view blog categories');
    }

    /**
     * Determine whether the user can create blog categories.
     */
    public function create(User $user): bool
    {
        return $user->can('create blog categories');
    }

    /**
     * Determine whether the user can update the blog category.
     */
    public function update(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('edit blog categories');
    }

    /**
     * Determine whether the user can delete the blog category.
     */
    public function delete(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('delete blog categories');
    }

    /**
     * Determine whether the user can restore the blog category.
     */
    public function restore(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('restore blog categories');
    }

    /**
     * Determine whether the user can permanently delete the blog category.
     */
    public function forceDelete(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('force delete blog categories');
    }

    /**
     * Determine whether the user can replicate the blog category.
     */
    public function replicate(User $user, BlogCategory $blogCategory): bool
    {
        return $user->can('replicate blog categories');
    }

    /**
     * Determine whether the user can reorder blog categories.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder blog categories');
    }
}
