<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

// All event/listener imports removed - using auto-discovery

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Removed manual registrations - using auto-discovery instead
        // This prevents duplicate email notifications being sent
        
        // EventRegistrationCreated::class => [EventRegistrationListener::class],
        // EventRegistrationUpdated::class => [EventRegistrationStatusUpdateListener::class],
        // AlHasalaCreated::class => [SendAlHasalaAdminNotification::class],
        // AlHasalaUpdated::class => [SendAlHasalaStatusNotification::class],
        // ContactMessageCreated::class => [SendContactMessageNotification::class],
        // MemberProfileCreated::class => [SendMemberProfileNotification::class],
        // UnionLoanCreated::class => [SendNewUnionLoanNotification::class],
        // UnionLoanUpdated::class => [SendUnionLoanStatusUpdate::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false; // We're manually registering events
    }
}
