<?php

namespace Database\Seeders;

use App\Models\AlHasalaSettings;
use Illuminate\Database\Seeder;

class AlHasalaSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AlHasalaSettings::create([
            'max_months' => 24,
            'receivers' => [
                [
                    'name' => 'Al Hasala Admin',
                    'email' => 'alhasala@example.com',
                ],
            ],
            'is_active' => true,
        ]);
    }
}
