<?php

namespace Database\Seeders;

use App\Models\AlHasala;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestAlHasalaEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'hussainammar12@gmail.com')->first();

        if (! $user) {
            $this->command->error('Test user not found!');

            return;
        }

        $alHasala = AlHasala::create([
            'user_id' => $user->id,
            'monthly_amount' => 200,
            'months' => 10,
            'total_amount' => 2000,
            'status' => 'pending',
            'note' => 'Testing fixed email template - no duplicate content',
        ]);

        $this->command->info('✓ Created AlHasala #' . $alHasala->id);
        $this->command->info('✓ Email notification queued for: hussainammar12@gmail.com');
        $this->command->newLine();
        $this->command->info('Run: php artisan queue:work --stop-when-empty');
        $this->command->info('to process the email.');
    }
}
