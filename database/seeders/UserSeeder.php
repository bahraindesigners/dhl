<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();
        $userRole = Role::where('name', 'user')->first();

        // Create admin user and assign Super Admin role
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        if ($superAdminRole) {
            $adminUser->assignRole($superAdminRole);
        }

        // Create test user and assign User role
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        if ($userRole) {
            $testUser->assignRole($userRole);
        }

        // Create event organizer user and assign Admin role
        $organizerUser = User::factory()->create([
            'name' => 'Event Organizer',
            'email' => 'organizer@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        if ($adminRole) {
            $organizerUser->assignRole($adminRole);
        }

        // Create editor user
        $editorUser = User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@dhl.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        if ($editorRole) {
            $editorUser->assignRole($editorRole);
        }

        // Create some additional random users for testing and assign User role
        $randomUsers = User::factory(5)->create([
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        if ($userRole) {
            foreach ($randomUsers as $user) {
                $user->assignRole($userRole);
            }
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: admin@dhl.test / password');
        $this->command->info('Admin: organizer@dhl.test / password');
        $this->command->info('Editor: editor@dhl.test / password');
        $this->command->info('User: test@dhl.test / password');
    }
}
