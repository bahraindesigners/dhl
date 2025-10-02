<?php

namespace Database\Seeders;

use App\LoanStatus;
use App\Models\AlHasala;
use App\Models\User;
use App\Models\MemberProfile;
use Illuminate\Database\Seeder;

class AlHasalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users with member profiles
        $usersWithProfiles = User::whereHas('memberProfile')->get();

        if ($usersWithProfiles->isEmpty()) {
            // Create some users with member profiles if none exist
            $user1 = User::factory()->create([
                'name' => 'Ahmed Al-Rashid',
                'email' => 'ahmed.rashid@dhl.test',
            ]);
            MemberProfile::factory()->create(['user_id' => $user1->id]);

            $user2 = User::factory()->create([
                'name' => 'Sara Al-Mahmoud',
                'email' => 'sara.mahmoud@dhl.test',
            ]);
            MemberProfile::factory()->create(['user_id' => $user2->id]);

            $user3 = User::factory()->create([
                'name' => 'Mohammed Hassan',
                'email' => 'mohammed.hassan@dhl.test',
            ]);
            MemberProfile::factory()->create(['user_id' => $user3->id]);

            $usersWithProfiles = collect([$user1, $user2, $user3]);
        }

        // Create diverse Al Hasala applications
        $alHasalaData = [
            [
                'user_id' => $usersWithProfiles->first()->id,
                'amount' => 2500.00,
                'months' => 18,
                'status' => LoanStatus::Pending,
                'note' => 'Al Hasala application for home renovation project. Need funds for kitchen and bathroom upgrades.',
            ],
            [
                'user_id' => $usersWithProfiles->get(1)->id ?? $usersWithProfiles->first()->id,
                'amount' => 1800.00,
                'months' => 12,
                'status' => LoanStatus::Approved,
                'note' => 'Al Hasala for educational purposes - children school fees and supplies.',
            ],
            [
                'user_id' => $usersWithProfiles->get(2) ? $usersWithProfiles->get(2)->id : $usersWithProfiles->first()->id,
                'amount' => 3200.00,
                'months' => 24,
                'status' => LoanStatus::Rejected,
                'note' => 'Al Hasala application for car purchase to improve family transportation.',
                'rejected_reason' => 'Current debt-to-income ratio exceeds acceptable limits. Please reapply after 6 months.',
            ],
            [
                'user_id' => $usersWithProfiles->first()->id,
                'amount' => 1500.00,
                'months' => 10,
                'status' => LoanStatus::Pending,
                'note' => 'Emergency Al Hasala for medical expenses.',
            ],
            [
                'user_id' => $usersWithProfiles->get(1)->id ?? $usersWithProfiles->first()->id,
                'amount' => 2200.00,
                'months' => 15,
                'status' => LoanStatus::Approved,
                'note' => 'Al Hasala for wedding preparations and ceremony expenses.',
            ],
        ];

        foreach ($alHasalaData as $data) {
            AlHasala::create($data);
        }

        $this->command->info('Created ' . count($alHasalaData) . ' Al Hasala applications with diverse statuses and scenarios.');
    }
}
