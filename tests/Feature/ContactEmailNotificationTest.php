<?php

use App\Events\ContactMessageCreated;
use App\Listeners\SendContactMessageNotification;
use App\Mail\NewContactMessage;
use App\Models\Contact;
use App\Models\ContactSetting;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\post;

beforeEach(function () {
    // Create a ContactSetting with notification email
    ContactSetting::factory()->create([
        'notification_email' => 'admin@test.com',
    ]);
});

it('dispatches ContactMessageCreated event when contact is created', function () {
    Event::fake([ContactMessageCreated::class]);

    $contactData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'subject' => 'Test Subject',
        'message' => 'Test message content',
    ];

    post('/contact', $contactData);

    Event::assertDispatched(ContactMessageCreated::class, function ($event) use ($contactData) {
        return $event->contact->name === $contactData['name'] &&
               $event->contact->email === $contactData['email'] &&
               $event->contact->subject === $contactData['subject'];
    });
});

it('sends email notification when ContactMessageCreated event is dispatched', function () {
    Mail::fake();
    Queue::fake();

    $contact = Contact::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'subject' => 'Test Inquiry',
        'message' => 'This is a test message',
    ]);

    $event = new ContactMessageCreated($contact);
    $listener = new SendContactMessageNotification();
    $listener->handle($event);

    Mail::assertSent(NewContactMessage::class, function ($mail) use ($contact) {
        return $mail->hasTo('admin@test.com') &&
               $mail->contact->id === $contact->id;
    });
});

it('does not send email when notification email is not set', function () {
    Mail::fake();

    // Update settings to remove notification email
    $settings = ContactSetting::first();
    $settings->update(['notification_email' => null]);

    $contact = Contact::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Test Subject',
        'message' => 'Test message',
    ]);

    $event = new ContactMessageCreated($contact);
    $listener = new SendContactMessageNotification();
    $listener->handle($event);

    Mail::assertNotSent(NewContactMessage::class);
});

it('does not send email when notification email is not configured', function () {
    Mail::fake();

    // Update settings to remove notification email
    $settings = ContactSetting::first();
    $settings->update(['notification_email' => null]);

    $contact = Contact::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Test Subject',
        'message' => 'Test message',
    ]);

    $event = new ContactMessageCreated($contact);
    $listener = new SendContactMessageNotification();
    $listener->handle($event);

    Mail::assertNotSent(NewContactMessage::class);
});

it('queues the email notification when queue is enabled in config', function () {
    Mail::fake();

    config(['contact.notifications.queue_enabled' => true]);

    $contact = Contact::factory()->create([
        'name' => 'Queue Test',
        'email' => 'queue@example.com',
        'subject' => 'Queue Test Subject',
        'message' => 'Queue test message',
    ]);

    // Manually trigger the listener to test the queue behavior
    $event = new ContactMessageCreated($contact);
    $listener = new SendContactMessageNotification();
    $listener->handle($event);

    // Since queue_enabled is true, the mail should be queued
    Mail::assertQueued(NewContactMessage::class, function ($mail) use ($contact) {
        return $mail->hasTo('admin@test.com') && $mail->contact->id === $contact->id;
    });
});

it('creates contact with proper form submission data', function () {
    $contactData = [
        'name' => 'Form Test User',
        'email' => 'form@example.com',
        'phone' => '+9876543210',
        'subject' => 'Form Test Subject',
        'message' => 'This is a form test message',
    ];

    $response = post('/contact', $contactData);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Thank you for your message! We will get back to you soon.');

    $this->assertDatabaseHas('contacts', [
        'name' => 'Form Test User',
        'email' => 'form@example.com',
        'phone' => '+9876543210',
        'subject' => 'Form Test Subject',
        'message' => 'This is a form test message',
    ]);
});
