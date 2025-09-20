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
        
        // Get the membership page settings for notification email
        $membershipPage = MembershipPage::getSingleton();
        
        try {
            // Send notification to admin if notification email is configured
            if ($membershipPage->notification_email) {
                Mail::to($membershipPage->notification_email)
                    ->queue(new NewMemberProfileNotification($memberProfile));
                    
                Log::info('Admin notification sent for new member profile', [
                    'member_profile_id' => $memberProfile->id,
                    'user_id' => $memberProfile->user_id,
                    'admin_email' => $membershipPage->notification_email,
                ]);
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
            Log::error('Failed to send member profile notification emails: ' . $e->getMessage(), [
                'member_profile_id' => $memberProfile->id,
                'user_id' => $memberProfile->user_id,
                'admin_email' => $membershipPage->notification_email,
                'user_email' => $memberProfile->user?->email,
                'exception' => $e->getTraceAsString(),
            ]);
        }
    }
}
