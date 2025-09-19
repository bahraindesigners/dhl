<?php

use App\Models\Contact;
use App\Models\ContactSetting;
use Illuminate\Support\Facades\Mail;

test('contact page can be accessed', function () {
    $response = $this->get('/contact');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('contact'));
});

test('contact page displays settings when available', function () {
    $settings = ContactSetting::getSingleton();
    $settings->update([
        'notification_email' => 'admin@dhlunion.bh',
        'instagram_url' => 'https://instagram.com/dhlunion',
        'linkedin_url' => 'https://linkedin.com/company/dhlunion',
        'x_url' => 'https://x.com/dhlunion',
        'office_address' => ['en' => 'DHL Bahrain Office', 'ar' => 'مكتب دي إتش إل البحرين'],
        'phone_numbers' => ['en' => '+973 1234 5678', 'ar' => '+973 1234 5678'],
        'office_hours' => ['en' => 'Sunday - Thursday: 8:00 AM - 5:00 PM', 'ar' => 'الأحد - الخميس: 8:00 صباحاً - 5:00 مساءً'],
        'is_active' => true,
    ]);

    $response = $this->get('/contact');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('contact')
        ->has('settings')
        ->where('settings.instagram_url', 'https://instagram.com/dhlunion')
        ->where('settings.linkedin_url', 'https://linkedin.com/company/dhlunion')
        ->where('settings.x_url', 'https://x.com/dhlunion')
    );
});

test('contact form submission works with all fields', function () {
    Mail::fake();

    $contactData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+973 1234 5678',
        'subject' => 'Test Subject',
        'message' => 'This is a test message.',
    ];

    $response = $this->post('/contact', $contactData);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Thank you for your message! We will get back to you soon.');

    $this->assertDatabaseHas('contacts', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+973 1234 5678',
        'subject' => 'Test Subject',
        'message' => 'This is a test message.',
    ]);
});

test('contact form submission works with minimal data', function () {
    Mail::fake();

    $contactData = [
        'name' => 'Jane Doe',
    ];

    $response = $this->post('/contact', $contactData);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('contacts', [
        'name' => 'Jane Doe',
        'email' => null,
        'phone' => null,
        'subject' => null,
        'message' => null,
    ]);
});

test('contact form validates email format', function () {
    $contactData = [
        'name' => 'John Doe',
        'email' => 'invalid-email',
        'message' => 'Test message',
    ];

    $response = $this->post('/contact', $contactData);

    $response->assertSessionHasErrors('email');
    $this->assertDatabaseMissing('contacts', ['email' => 'invalid-email']);
});

test('email notification is sent when contact setting exists', function () {
    Mail::fake();

    $settings = ContactSetting::getSingleton();
    $settings->update([
        'notification_email' => 'admin@dhlunion.bh',
        'is_active' => true,
    ]);

    $contactData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'Test message',
    ];

    $this->post('/contact', $contactData);

    Mail::assertSent(\App\Mail\NewContactMessage::class);
});

test('contact can be marked as read', function () {
    $contact = Contact::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'Test message',
        'is_read' => false,
    ]);

    expect($contact->is_read)->toBeFalse();
    expect($contact->read_at)->toBeNull();

    $contact->markAsRead();

    expect($contact->fresh()->is_read)->toBeTrue();
    expect($contact->fresh()->read_at)->not->toBeNull();
});
