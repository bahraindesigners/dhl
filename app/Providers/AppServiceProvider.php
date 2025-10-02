<?php

namespace App\Providers;

use App\Events\AlHasalaCreated;
use App\Events\AlHasalaUpdated;
use App\Events\ContactMessageCreated;
use App\Events\EventRegistrationCreated;
use App\Events\MemberProfileCreated;
use App\Events\UnionLoanCreated;
use App\Events\UnionLoanUpdated;
use App\Listeners\EventRegistrationListener;
use App\Listeners\SendAlHasalaAdminNotification;
use App\Listeners\SendAlHasalaStatusNotification;
use App\Listeners\SendContactMessageNotification;
use App\Listeners\SendMemberProfileNotification;
use App\Listeners\SendNewUnionLoanNotification;
use App\Listeners\SendUnionLoanStatusUpdate;
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
            if ($user?->hasRole('super_admin')) {
                return true;
            }

            return null;
        });

        // Register event listeners
        Event::listen(
            EventRegistrationCreated::class,
            EventRegistrationListener::class
        );

        Event::listen(
            UnionLoanCreated::class,
            SendNewUnionLoanNotification::class
        );

        Event::listen(
            UnionLoanUpdated::class,
            SendUnionLoanStatusUpdate::class
        );

        Event::listen(
            ContactMessageCreated::class,
            SendContactMessageNotification::class
        );

        Event::listen(
            MemberProfileCreated::class,
            SendMemberProfileNotification::class
        );

        Event::listen(
            AlHasalaCreated::class,
            SendAlHasalaAdminNotification::class
        );

        Event::listen(
            AlHasalaUpdated::class,
            SendAlHasalaStatusNotification::class
        );
    }
}
