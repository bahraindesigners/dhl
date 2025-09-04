<?php

namespace App\Policies;

use App\Models\HomeSlider;
use App\Models\User;

class HomeSliderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view home sliders');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HomeSlider $homeSlider): bool
    {
        return $user->can('view home sliders');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create home sliders');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HomeSlider $homeSlider): bool
    {
        return $user->can('edit home sliders');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HomeSlider $homeSlider): bool
    {
        return $user->can('delete home sliders');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HomeSlider $homeSlider): bool
    {
        return $user->can('restore home sliders');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HomeSlider $homeSlider): bool
    {
        return $user->can('force delete home sliders');
    }
}
