<?php

use App\Events\MemberProfileCreated;
use App\Listeners\SendMemberProfileNotification;
use App\Mail\MemberProfileConfirmation;
use App\Mail\NewMemberProfileNotification;
use App\Models\MemberProfile;
use App\Models\MembershipPage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    // Create a MembershipPage with notification email
    MembershipPage::getSingleton()->update([
        'notification_email' => 'admin@test.com',
    ]);
});

it('dispatches MemberProfileCreated event when member profile is created', function () {
    Event::fake([MemberProfileCreated::class]);

    $user = User::factory()->create();
    actingAs($user);

    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
    ]);

    Event::assertDispatched(MemberProfileCreated::class, function ($event) use ($memberProfile) {
        return $event->memberProfile->id === $memberProfile->id;
    });
});

it('sends admin notification email when new member profile is created', function () {
    Mail::fake();

    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
    ]);

    $event = new MemberProfileCreated($memberProfile);
    $listener = new SendMemberProfileNotification;
    $listener->handle($event);

    Mail::assertQueued(NewMemberProfileNotification::class, function ($mail) use ($memberProfile) {
        return $mail->hasTo('admin@test.com') &&
               $mail->memberProfile->id === $memberProfile->id;
    });
});

it('sends user confirmation email when new member profile is created', function () {
    Mail::fake();

    $user = User::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
    ]);

    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
    ]);

    $event = new MemberProfileCreated($memberProfile);
    $listener = new SendMemberProfileNotification;
    $listener->handle($event);

    Mail::assertQueued(MemberProfileConfirmation::class, function ($mail) use ($user, $memberProfile) {
        return $mail->hasTo($user->email) &&
               $mail->memberProfile->id === $memberProfile->id;
    });
});

it('does not send admin notification when notification email is not configured', function () {
    Mail::fake();

    // Update membership page to remove notification email
    MembershipPage::getSingleton()->update(['notification_email' => null]);

    $user = User::factory()->create();
    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
    ]);

    $event = new MemberProfileCreated($memberProfile);
    $listener = new SendMemberProfileNotification;
    $listener->handle($event);

    Mail::assertNotQueued(NewMemberProfileNotification::class);
});

it('still sends user confirmation even when admin notification is disabled', function () {
    Mail::fake();

    // Update membership page to remove notification email
    MembershipPage::getSingleton()->update(['notification_email' => null]);

    $user = User::factory()->create([
        'email' => 'user@example.com',
    ]);

    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
    ]);

    $event = new MemberProfileCreated($memberProfile);
    $listener = new SendMemberProfileNotification;
    $listener->handle($event);

    Mail::assertQueued(MemberProfileConfirmation::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
});

it('handles user with no email gracefully', function () {
    Mail::fake();

    // Create a user with an empty email
    $user = User::factory()->create([
        'email' => '',
    ]);

    $memberProfile = MemberProfile::factory()->create([
        'user_id' => $user->id,
    ]);

    $event = new MemberProfileCreated($memberProfile);
    $listener = new SendMemberProfileNotification;

    // Should not throw exception
    $listener->handle($event);

    // Admin notification should still be sent
    Mail::assertQueued(NewMemberProfileNotification::class);

    // User confirmation should not be sent (no user email available)
    Mail::assertNotQueued(MemberProfileConfirmation::class);
});

it('sends both emails when member profile is created via controller', function () {
    Mail::fake();

    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    actingAs($user);

    // Simulate form submission data
    $memberProfileData = [
        'cpr_number' => '123456789',
        'staff_number' => 'EMP001',
        'nationality' => 'Bahraini',
        'gender' => 'male',
        'marital_status' => 'single',
        'date_of_joining' => '2025-01-01',
        'position' => 'Software Developer',
        'department' => 'IT',
        'section' => 'Development',
        'working_place_address' => 'DHL Office',
        'office_phone' => '+973 123 456',
        'education_qualification' => 'Bachelors Degree',
        'mobile_number' => '+973 987 654',
        'home_phone' => '+973 111 222',
        'permanent_address' => 'Manama, Bahrain',
        'employee_image' => UploadedFile::fake()->image('employee.jpg'),
        'was_previous_member' => 'no',
    ];

    // Submit membership application
    $response = $this->post('/membership', $memberProfileData);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    // Check that both emails are queued
    Mail::assertQueued(NewMemberProfileNotification::class, function ($mail) use ($user) {
        return $mail->hasTo('admin@test.com') &&
               $mail->memberProfile->user_id === $user->id;
    });

    Mail::assertQueued(MemberProfileConfirmation::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email) &&
               $mail->memberProfile->user_id === $user->id;
    });
});
