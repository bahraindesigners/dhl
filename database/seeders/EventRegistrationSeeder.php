<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class EventRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing events and users
        $events = Event::all();
        $users = User::all();

        if ($events->isEmpty()) {
            $this->command->info('No events found. Running EventSeeder first...');
            $this->call(EventSeeder::class);
            $events = Event::all();
        }

        if ($users->isEmpty()) {
            $this->command->info('No users found. Creating sample users...');
            User::factory(20)->create();
            $users = User::all();
        }

        $this->command->info('Creating event registrations...');

        // Create registrations for each event
        foreach ($events as $event) {
            // Get existing registrations for this event
            $existingEmails = EventRegistration::where('event_id', $event->id)
                ->pluck('email')
                ->toArray();

            // Calculate how many registrations this event should have
            $maxRegistrations = min($event->capacity, 50); // Cap at 50 for seeding
            $currentRegistrationCount = count($existingEmails);
            $targetRegistrationCount = max($currentRegistrationCount, rand(5, $maxRegistrations));
            $newRegistrationsNeeded = $targetRegistrationCount - $currentRegistrationCount;

            if ($newRegistrationsNeeded <= 0) {
                $this->command->info("Event '{$event->title}' already has enough registrations ({$currentRegistrationCount})");
                continue;
            }

            $this->command->info("Creating {$newRegistrationsNeeded} new registrations for event: {$event->title}");

            // Create a mix of registered and unregistered users
            for ($i = 0; $i < $newRegistrationsNeeded; $i++) {
                $attempts = 0;
                $maxAttempts = 10;
                
                while ($attempts < $maxAttempts) {
                    $isRegisteredUser = rand(1, 100) <= 70; // 70% chance of being a registered user
                    
                    $registrationData = [
                        'event_id' => $event->id,
                        'registered_at' => $this->getRandomRegistrationDate($event),
                        'amount_paid' => $event->price ?? 0,
                    ];

                    if ($isRegisteredUser && $users->isNotEmpty()) {
                        // Use existing user
                        $user = $users->random();
                        $email = $user->email;
                        
                        // Check if this user already registered for this event
                        if (in_array($email, $existingEmails)) {
                            $attempts++;
                            continue; // Try again with different user
                        }
                        
                        $registrationData = array_merge($registrationData, [
                            'user_id' => $user->id,
                            'first_name' => $user->name ? explode(' ', $user->name)[0] : fake()->firstName,
                            'last_name' => $user->name ? (explode(' ', $user->name)[1] ?? '') : fake()->lastName,
                            'email' => $email,
                        ]);
                    } else {
                        // Guest registration - generate unique email
                        do {
                            $email = fake()->unique()->safeEmail;
                        } while (in_array($email, $existingEmails));
                        
                        $registrationData = array_merge($registrationData, [
                            'user_id' => null,
                            'first_name' => fake()->firstName,
                            'last_name' => fake()->lastName,
                            'email' => $email,
                        ]);
                    }

                    // Add this email to existing emails to prevent duplicates in this run
                    $existingEmails[] = $registrationData['email'];

                    // Add additional registration details
                    $registrationData = array_merge($registrationData, [
                        'phone' => fake()->phoneNumber,
                        'special_requirements' => rand(1, 100) <= 30 ? fake()->sentence : null,
                        'status' => $this->getRandomStatus(),
                        'payment_status' => $this->getRandomPaymentStatus($event->price ?? 0),
                        'payment_method' => $this->getRandomPaymentMethod(),
                        'payment_reference' => 'REF-' . strtoupper(fake()->lexify('??????')),
                        'registration_data' => $this->getRandomRegistrationData(),
                        'admin_notes' => rand(1, 100) <= 20 ? fake()->sentence : null,
                    ]);

                    // Set confirmed_at and cancelled_at based on status
                    if ($registrationData['status'] === 'confirmed') {
                        $registrationData['confirmed_at'] = Carbon::parse($registrationData['registered_at'])->addHours(rand(1, 48));
                    } elseif ($registrationData['status'] === 'cancelled') {
                        $registrationData['cancelled_at'] = Carbon::parse($registrationData['registered_at'])->addHours(rand(1, 72));
                    }

                    try {
                        EventRegistration::create($registrationData);
                        break; // Success, move to next registration
                    } catch (\Exception $e) {
                        $attempts++;
                        if ($attempts >= $maxAttempts) {
                            $this->command->error("Failed to create registration after {$maxAttempts} attempts: " . $e->getMessage());
                        }
                    }
                }
            }

            // Update the event's registered_count
            $actualCount = EventRegistration::where('event_id', $event->id)->count();
            $event->update(['registered_count' => $actualCount]);
        }

        // Create some additional registrations with specific scenarios
        $this->createSpecialScenarios($events, $users);

        $this->command->info('Event registrations seeded successfully!');
    }

    /**
     * Get a random registration date within the event's registration period
     */
    private function getRandomRegistrationDate(Event $event): Carbon
    {
        $startDate = $event->registration_starts_at ?? $event->created_at ?? now()->subDays(30);
        $endDate = min(
            $event->registration_ends_at ?? now(),
            $event->start_date ?? now()->addDays(30),
            now()
        );

        return Carbon::parse($startDate)->addSeconds(
            rand(0, Carbon::parse($endDate)->diffInSeconds($startDate))
        );
    }

    /**
     * Get a random status with realistic distribution
     */
    private function getRandomStatus(): string
    {
        $statuses = [
            'confirmed' => 60,  // 60% confirmed
            'pending' => 25,    // 25% pending
            'cancelled' => 10,  // 10% cancelled
            'attended' => 5,    // 5% attended (for past events)
        ];

        $random = rand(1, 100);
        $cumulative = 0;

        foreach ($statuses as $status => $probability) {
            $cumulative += $probability;
            if ($random <= $cumulative) {
                return $status;
            }
        }

        return 'pending';
    }

    /**
     * Get a random payment status based on event price
     */
    private function getRandomPaymentStatus(float $price): string
    {
        if ($price == 0) {
            return 'paid'; // Free events are automatically "paid"
        }

        $statuses = [
            'paid' => 70,      // 70% paid
            'pending' => 20,   // 20% pending
            'failed' => 8,     // 8% failed
            'refunded' => 2,   // 2% refunded
        ];

        $random = rand(1, 100);
        $cumulative = 0;

        foreach ($statuses as $status => $probability) {
            $cumulative += $probability;
            if ($random <= $cumulative) {
                return $status;
            }
        }

        return 'pending';
    }

    /**
     * Get a random payment method
     */
    private function getRandomPaymentMethod(): string
    {
        $methods = ['credit_card', 'paypal', 'bank_transfer', 'cash', 'knet'];
        return $methods[array_rand($methods)];
    }

    /**
     * Get random registration data
     */
    private function getRandomRegistrationData(): array
    {
        $data = [
            'emergency_contact' => fake()->name,
            'emergency_phone' => fake()->phoneNumber,
        ];

        // Add optional fields randomly
        if (rand(1, 100) <= 30) {
            $data['dietary_requirements'] = fake()->randomElement([
                'Vegetarian', 'Vegan', 'Gluten-free', 'Halal', 'No dairy', 'No nuts'
            ]);
        }

        if (rand(1, 100) <= 20) {
            $data['company'] = fake()->company;
            $data['job_title'] = fake()->jobTitle;
        }

        if (rand(1, 100) <= 15) {
            $data['t_shirt_size'] = fake()->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']);
        }

        return $data;
    }

    /**
     * Create some special registration scenarios for testing
     */
    private function createSpecialScenarios(Collection $events, Collection $users): void
    {
        if ($events->isEmpty() || $users->isEmpty()) {
            return;
        }

        $firstEvent = $events->first();
        $firstUser = $users->first();

        // Get existing registrations for the first event
        $existingEmails = EventRegistration::where('event_id', $firstEvent->id)
            ->pluck('email')
            ->toArray();

        // Scenario 1: VIP registration with high amount (only if not exists)
        $vipEmail = 'vip@example.com';
        if (!in_array($vipEmail, $existingEmails)) {
            try {
                EventRegistration::create([
                    'event_id' => $firstEvent->id,
                    'user_id' => $firstUser->id,
                    'first_name' => $firstUser->name ? explode(' ', $firstUser->name)[0] : 'VIP',
                    'last_name' => $firstUser->name ? (explode(' ', $firstUser->name)[1] ?? '') : 'Member',
                    'email' => $vipEmail,
                    'phone' => '+965 1234 5678',
                    'special_requirements' => 'VIP seating and special dietary requirements',
                    'status' => 'confirmed',
                    'registered_at' => now()->subDays(10),
                    'confirmed_at' => now()->subDays(9),
                    'amount_paid' => ($firstEvent->price ?? 100) * 1.5, // VIP pricing
                    'payment_status' => 'paid',
                    'payment_method' => 'credit_card',
                    'payment_reference' => 'VIP-' . strtoupper(fake()->lexify('??????')),
                    'registration_data' => [
                        'emergency_contact' => 'Emergency Contact Name',
                        'emergency_phone' => '+965 9876 5432',
                        'dietary_requirements' => 'Vegan',
                        'company' => 'VIP Corporation',
                        'job_title' => 'CEO',
                        'vip_level' => 'Platinum',
                    ],
                    'admin_notes' => 'VIP registration - provide special attention',
                ]);
                $this->command->info('VIP registration scenario created!');
            } catch (\Exception $e) {
                $this->command->info('VIP registration already exists, skipping...');
            }
        }

        // Scenario 2: Group registration (only if not exists)
        $groupLeader = $users->skip(1)->first();
        $groupBaseEmail = 'group-leader@example.com';
        
        if (!in_array($groupBaseEmail, $existingEmails)) {
            try {
                for ($i = 0; $i < 5; $i++) {
                    $groupEmail = $i === 0 ? $groupBaseEmail : "group-member-{$i}@example.com";
                    
                    // Skip if this email already exists
                    if (in_array($groupEmail, $existingEmails)) {
                        continue;
                    }
                    
                    EventRegistration::create([
                        'event_id' => $firstEvent->id,
                        'user_id' => $i === 0 ? $groupLeader->id : null,
                        'first_name' => $i === 0 ? 
                            ($groupLeader->name ? explode(' ', $groupLeader->name)[0] : 'Group') : 
                            fake()->firstName,
                        'last_name' => $i === 0 ? 
                            ($groupLeader->name ? (explode(' ', $groupLeader->name)[1] ?? '') : 'Leader') : 
                            fake()->lastName,
                        'email' => $groupEmail,
                        'phone' => fake()->phoneNumber,
                        'status' => 'confirmed',
                        'registered_at' => now()->subDays(15),
                        'confirmed_at' => now()->subDays(14),
                        'amount_paid' => ($firstEvent->price ?? 100) * 0.8, // Group discount
                        'payment_status' => 'paid',
                        'payment_method' => 'bank_transfer',
                        'payment_reference' => 'GROUP-REG-' . ($i + 1),
                        'registration_data' => [
                            'emergency_contact' => fake()->name,
                            'emergency_phone' => fake()->phoneNumber,
                            'group_registration' => true,
                            'group_leader' => $i === 0 ? true : false,
                            'group_id' => 'GRP-001',
                        ],
                        'admin_notes' => $i === 0 ? 'Group leader - 5 people total' : 'Part of group registration GRP-001',
                    ]);
                }
                $this->command->info('Group registration scenario created!');
            } catch (\Exception $e) {
                $this->command->info('Some group registrations may already exist, continuing...');
            }
        }
    }
}
