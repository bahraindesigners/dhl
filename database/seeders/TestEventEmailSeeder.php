<?php

namespace Database\Seeders;

use App\Events\EventRegistrationCreated;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TestEventEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testEmail = 'hussainammar12@gmail.com';

        Log::info('Starting TestEventEmailSeeder');

        // Find or create an event category
        $eventCategory = EventCategory::first();

        if (! $eventCategory) {
            Log::info('No event category found, creating one');
            $eventCategory = EventCategory::create([
                'name' => ['en' => 'Test Category', 'ar' => 'فئة الاختبار'],
                'description' => ['en' => 'Test category for email testing', 'ar' => 'فئة اختبار لاختبار البريد الإلكتروني'],
                'receiver_emails' => [$testEmail],
                'is_active' => true,
                'sort_order' => 1,
            ]);
        } else {
            // Update existing category to use test email
            $eventCategory->update([
                'receiver_emails' => [$testEmail],
            ]);
            Log::info('Updated event category receiver emails', [
                'category_id' => $eventCategory->id,
                'receiver_emails' => $testEmail,
            ]);
        }

        // Find or create an event
        $event = Event::where('event_category_id', $eventCategory->id)->first();

        if (! $event) {
            Log::info('No event found, creating one');
            $event = Event::create([
                'event_category_id' => $eventCategory->id,
                'title' => ['en' => 'Test Event', 'ar' => 'حدث الاختبار'],
                'slug' => ['en' => 'test-event-' . now()->timestamp, 'ar' => 'test-event-' . now()->timestamp],
                'description' => ['en' => 'Test event description', 'ar' => 'وصف حدث الاختبار'],
                'content' => ['en' => 'Test event content', 'ar' => 'محتوى حدث الاختبار'],
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(31),
                'status' => 'published',
                'location' => 'Test Location, Manama',
                'location_details' => ['en' => 'Test Location Details', 'ar' => 'تفاصيل الموقع الاختبار'],
                'capacity' => 100,
                'registered_count' => 0,
                'registration_enabled' => true,
                'registration_starts_at' => now(),
                'registration_ends_at' => now()->addDays(29),
                'price' => 50.00,
                'published_at' => now(),
            ]);
        }

        // Find a user or use the first available user
        $user = User::first();

        if (! $user) {
            Log::warning('No user found in database');

            return;
        }

        // Create a test event registration
        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'first_name' => 'Test',
            'last_name' => 'Registration',
            'email' => $testEmail,
            'phone' => '+973 1234 5678',
            'status' => 'pending',
            'registered_at' => now(),
            'payment_status' => 'pending',
            'amount_paid' => 50.00,
        ]);

        Log::info('Created test event registration', [
            'registration_id' => $registration->id,
            'event_id' => $event->id,
            'user_id' => $user->id,
            'email' => $testEmail,
        ]);

        // Fire the event to trigger emails
        event(new EventRegistrationCreated($registration));

        Log::info('EventRegistrationCreated event dispatched');

        $this->command->info('✅ Test event registration created successfully!');
        $this->command->info("📧 Emails will be sent to: {$testEmail}");
        $this->command->info("📝 Registration ID: {$registration->id}");
        $this->command->info("🎫 Event: {$event->getTranslation('title', 'en')}");
        $this->command->info('');
        $this->command->info('⚠️  Run the queue worker to process emails:');
        $this->command->info('   php artisan queue:work --stop-when-empty');
    }
}
