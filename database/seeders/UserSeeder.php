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
        $superAdminRole = Role::where('name', 'Super Admin')->first();

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
        $this->command->info('Users seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: admin@dhl.test / password');
    }
}
