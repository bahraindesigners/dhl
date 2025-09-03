<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create event organizer user
        User::factory()->create([
            'name' => 'Event Organizer',
            'email' => 'organizer@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create some additional random users for testing
        User::factory(5)->create([
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Users seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@dhl.test / password');
        $this->command->info('Test User: test@dhl.test / password');
        $this->command->info('Event Organizer: organizer@dhl.test / password');
    }
}
