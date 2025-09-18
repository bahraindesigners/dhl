<?php

namespace App\Providers;

use App\Events\EventRegistrationCreated;
use App\Listeners\EventRegistrationListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "Super Admin" role all permissions with Spatie Permission.
        // This works in the app by using gate-related functions like auth()->user()->can() and @can().
        Gate::before(function ($user, $ability) {
            if ($user?->hasRole('Super Admin')) {
                return true;
            }

            return null;
        });

        // Register event listeners
        Event::listen(
            EventRegistrationCreated::class,
            EventRegistrationListener::class
        );
    }
}
