<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnionLoanSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'max_months',
        'min_amount',
        'max_amount',
        'min_monthly_payment',
        'receivers',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'max_months' => 'integer',
            'min_amount' => 'decimal:2',
            'max_amount' => 'decimal:2',
            'min_monthly_payment' => 'decimal:2',
            'receivers' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public static function getActiveSettings(): ?self
    {
        return self::where('is_active', true)->first();
    }

    public static function getSingleton(): self
    {
        return self::first() ?? self::create([
            'max_months' => 24,
            'min_amount' => 100.00,
            'max_amount' => 10000.00,
            'min_monthly_payment' => 75.00,
            'receivers' => [
                [
                    'name' => 'Loan Admin',
                    'email' => 'loans@example.com',
                ],
            ],
            'is_active' => true,
        ]);
    }

    /**
     * Calculate the maximum allowed duration (months) for a given loan amount
     * based on the minimum monthly payment requirement.
     */
    public function getMaxDurationForAmount(float $amount): int
    {
        if ($this->min_monthly_payment <= 0) {
            return $this->max_months;
        }

        $maxDuration = floor($amount / $this->min_monthly_payment);

        return min((int) $maxDuration, $this->max_months);
    }

    /**
     * Calculate the monthly payment for a given amount and duration.
     */
    public function calculateMonthlyPayment(float $amount, int $months): float
    {
        if ($months <= 0) {
            return 0;
        }

        return round($amount / $months, 2);
    }

    /**
     * Validate if a loan amount and duration combination is valid.
     */
    public function isValidLoanCombination(float $amount, int $months): bool
    {
        // Check amount limits
        if ($amount < $this->min_amount || $amount > $this->max_amount) {
            return false;
        }

        // Check duration limits
        if ($months < 1 || $months > $this->max_months) {
            return false;
        }

        // Check minimum monthly payment requirement
        $monthlyPayment = $this->calculateMonthlyPayment($amount, $months);

        return $monthlyPayment >= $this->min_monthly_payment;
    }

    /**
     * Get validation error message for invalid loan combination.
     */
    public function getValidationError(float $amount, int $months): ?string
    {
        if ($amount < $this->min_amount) {
            return "Loan amount must be at least BD {$this->min_amount}.";
        }

        if ($amount > $this->max_amount) {
            return "Loan amount cannot exceed BD {$this->max_amount}.";
        }

        if ($months < 1) {
            return "Loan duration must be at least 1 month.";
        }

        if ($months > $this->max_months) {
            return "Loan duration cannot exceed {$this->max_months} months.";
        }

        $monthlyPayment = $this->calculateMonthlyPayment($amount, $months);
        if ($monthlyPayment < $this->min_monthly_payment) {
            return "Monthly payment (BD {$monthlyPayment}) must be at least BD {$this->min_monthly_payment}.";
        }

        return null;
    }
}
