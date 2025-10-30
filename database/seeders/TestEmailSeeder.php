<?php

namespace Database\Seeders;

use App\Models\AlHasala;
use App\Models\AlHasalaSettings;
use App\Models\MemberProfile;
use App\Models\UnionLoan;
use App\Models\UnionLoanSettings;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update Union Loan Settings
        $loanSettings = UnionLoanSettings::first();
        if ($loanSettings) {
            $loanSettings->update([
                'receivers' => [
                    [
                        'name' => 'Hussain Ammar',
                        'email' => 'hussainammar12@gmail.com',
                    ],
                ],
                'is_active' => true,
            ]);
            $this->command->info('✓ Union Loan Settings updated');
        }

        // Update AlHasala Settings
        $alHasalaSettings = AlHasalaSettings::first();
        if ($alHasalaSettings) {
            $alHasalaSettings->update([
                'receivers' => [
                    [
                        'name' => 'Hussain Ammar',
                        'email' => 'hussainammar12@gmail.com',
                    ],
                ],
                'is_active' => true,
            ]);
            $this->command->info('✓ AlHasala Settings updated');
        }

        // Find or create test user
        $user = User::where('email', 'hussainammar12@gmail.com')->first();
        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Hussain Ammar',
                'email' => 'hussainammar12@gmail.com',
                'password' => bcrypt('password'),
            ]);
            $this->command->info('✓ Created test user');
        } else {
            $this->command->info('✓ Test user already exists');
        }

        // Check if user has member profile
        $memberProfile = $user->memberProfile;
        if (! $memberProfile) {
            $memberProfile = MemberProfile::factory()->for($user)->create([
                'profile_status' => true,
                'staff_number' => 'DHL-TEST-' . rand(1000, 9999),
                'department' => 'IT Department',
                'position' => 'Test Position',
            ]);
            $this->command->info('✓ Created member profile');
        } else {
            $this->command->info('✓ Member profile already exists');
        }

        $this->command->newLine();
        $this->command->info('Email settings configured for testing!');
        $this->command->info('Test email: hussainammar12@gmail.com');
        $this->command->newLine();
        $this->command->info('To test emails, create a new Union Loan or AlHasala application.');
        $this->command->info('Emails will be sent to: hussainammar12@gmail.com');
    }
}
