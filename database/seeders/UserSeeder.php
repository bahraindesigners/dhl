<?php

namespace Database\Seeders;

use App\Models\User;
use Hexters\HexaLite\Models\HexaRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $superAdminRole = HexaRole::where('name', 'Superusers')->first();
        $adminRole = HexaRole::where('name', 'Admin')->first();
        $editorRole = HexaRole::where('name', 'Editor')->first();
        $userRole = HexaRole::where('name', 'User')->first();

        // Create admin user and assign Super Admin role
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $adminUser->roles()->attach($superAdminRole->id);

        // Create test user and assign User role
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $testUser->roles()->attach($userRole->id);

        // Create event organizer user and assign Admin role
        $organizerUser = User::factory()->create([
            'name' => 'Event Organizer',
            'email' => 'organizer@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $organizerUser->roles()->attach($adminRole->id);

        // Create editor user
        $editorUser = User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $editorUser->roles()->attach($editorRole->id);

        // Create some additional random users for testing and assign User role
        $randomUsers = User::factory(5)->create([
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        foreach ($randomUsers as $user) {
            $user->roles()->attach($userRole->id);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: admin@dhl.test / password');
        $this->command->info('Admin: organizer@dhl.test / password');
        $this->command->info('Editor: editor@dhl.test / password');
        $this->command->info('User: test@dhl.test / password');
    }
}
