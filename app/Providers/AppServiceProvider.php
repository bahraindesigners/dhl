<?php

namespace App\Providers;

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

        // Event listeners are auto-discovered by Laravel 11+
        // No manual registration needed - Laravel automatically maps:
        // EventName -> EventNameListener (by convention)
        // Or uses the handle() method in listener classes
    }
}
