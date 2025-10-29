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
        // Ensure roles exist first
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if (! $superAdminRole) {
            $this->command->error('Super admin role not found! Please run PermissionSeeder first:');
            $this->command->error('php artisan db:seed --class=PermissionSeeder');

            return;
        }

        // Create admin user and assign Super Admin role
        $adminUser = User::updateOrCreate(
            ['email' => 'hussain@lamma.ai'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (! $adminUser->hasRole($superAdminRole)) {
            $adminUser->assignRole($superAdminRole);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Super Admin: admin@dhl.test / password');
        $this->command->info('Roles assigned: '.$adminUser->getRoleNames()->implode(', '));
    }
}
