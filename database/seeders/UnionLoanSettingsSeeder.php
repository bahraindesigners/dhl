<?php

namespace Database\Seeders;

use App\Models\UnionLoanSettings;
use Illuminate\Database\Seeder;

class UnionLoanSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnionLoanSettings::create([
            'max_months' => 36, // 3 years maximum
            'min_amount' => 100.00, // Minimum loan amount
            'max_amount' => 10000.00, // Maximum loan amount
            'min_monthly_payment' => 75.00, // Minimum monthly payment requirement
            'receivers' => [
                [
                    'email' => 'admin@dhl.test',
                    'name' => 'Admin User',
                ],
                [
                    'email' => 'hr@dhl.test',
                    'name' => 'HR Department',
                ],
            ],
            'is_active' => true,
        ]);
    }
}
