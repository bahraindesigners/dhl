<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MemberProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding member profiles...');

        // Get existing users
        $users = \App\Models\User::all();

        if ($users->count() < 2) {
            // Create some additional users if needed
            $users = $users->merge([
                \App\Models\User::factory()->create(['name' => 'Ahmed Al-Mahmood', 'email' => 'ahmed.mahmood@dhl.test']),
                \App\Models\User::factory()->create(['name' => 'Fatima Al-Zahra', 'email' => 'fatima.zahra@dhl.test']),
            ]);
        }

        // Create specific profiles for the first two users
        $specificProfiles = [
            [
                'user_id' => $users->first()->id,
                'cpr_number' => '123456789',
                'staff_number' => 'EMP001',
                'nationality' => 'Bahraini',
                'gender' => 'male',
                'marital_status' => 'married',
                'date_of_joining' => '2020-01-15',
                'position' => 'Senior Manager',
                'department' => 'Human Resources',
                'section' => 'Recruitment',
                'working_place_address' => 'Building A, Floor 3, Office 301',
                'office_phone' => '+973 1234 5678',
                'education_qualification' => 'Masters Degree',
                'mobile_number' => '+973 9876 5432',
                'home_phone' => '+973 1111 2222',
                'permanent_address' => 'Block 123, Road 456, Manama, Bahrain',
                'profile_status' => true,
            ],
            [
                'user_id' => $users->get(1)->id,
                'cpr_number' => '987654321',
                'staff_number' => 'EMP002',
                'nationality' => 'Bahraini',
                'gender' => 'female',
                'marital_status' => 'single',
                'date_of_joining' => '2021-03-10',
                'position' => 'Financial Analyst',
                'department' => 'Finance',
                'section' => 'Budgeting',
                'working_place_address' => 'Building B, Floor 2, Office 205',
                'office_phone' => '+973 2345 6789',
                'education_qualification' => 'Bachelors Degree',
                'mobile_number' => '+973 8765 4321',
                'permanent_address' => 'Block 234, Road 567, Riffa, Bahrain',
                'profile_status' => true,
            ],
        ];

        foreach ($specificProfiles as $profileData) {
            \App\Models\MemberProfile::create($profileData);
        }

        // Create additional random profiles using factory
        $remainingUsers = $users->skip(2);
        foreach ($remainingUsers->take(8) as $user) {
            \App\Models\MemberProfile::factory()->create(['user_id' => $user->id]);
        }

        $this->command->info('Member profiles seeded successfully!');
    }
}
