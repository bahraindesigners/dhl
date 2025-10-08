<?php

namespace App\Listeners;

use App\Events\MemberProfileCreated;
use App\Mail\MemberProfileConfirmation;
use App\Mail\NewMemberProfileNotification;
use App\Models\MembershipPage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMemberProfileNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MemberProfileCreated $event): void
    {
        $memberProfile = $event->memberProfile;

        // Get the membership page settings for notification emails
        $membershipPage = MembershipPage::getSingleton();

        try {
            // Send notification to admins if notification emails are configured
            $notificationEmails = $membershipPage->notification_emails ?? [];

            if (! empty($notificationEmails)) {
                // Filter out any invalid emails
                $validEmails = array_filter($notificationEmails, function ($email) {
                    return filter_var($email, FILTER_VALIDATE_EMAIL);
                });

                if (! empty($validEmails)) {
                    Mail::to($validEmails)
                        ->queue(new NewMemberProfileNotification($memberProfile));

                    Log::info('Admin notifications sent for new member profile', [
                        'member_profile_id' => $memberProfile->id,
                        'user_id' => $memberProfile->user_id,
                        'admin_emails' => $validEmails,
                        'email_count' => count($validEmails),
                    ]);
                }
            }

            // Send confirmation email to the user
            if ($memberProfile->user && $memberProfile->user->email) {
                Mail::to($memberProfile->user->email)
                    ->queue(new MemberProfileConfirmation($memberProfile));

                Log::info('User confirmation sent for new member profile', [
                    'member_profile_id' => $memberProfile->id,
                    'user_id' => $memberProfile->user_id,
                    'user_email' => $memberProfile->user->email,
                ]);
            }

        } catch (\Exception $e) {
            // Log the error but don't fail the process
            Log::error('Failed to send member profile notification emails: '.$e->getMessage(), [
                'member_profile_id' => $memberProfile->id,
                'user_id' => $memberProfile->user_id,
                'admin_emails' => $membershipPage->notification_emails ?? [],
                'user_email' => $memberProfile->user?->email,
                'exception' => $e->getTraceAsString(),
            ]);
        }
    }
}
