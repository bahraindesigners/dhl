<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlHasalaSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'max_months',
        'min_monthly_payment',
        'receivers',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'max_months' => 'integer',
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
            'min_monthly_payment' => 50.00,
            'receivers' => [
                [
                    'name' => 'Al Hasala Admin',
                    'email' => 'alhasala@example.com',
                ],
            ],
            'is_active' => true,
        ]);
    }

    public function calculateTotalAmount(float $monthlyAmount, int $months): float
    {
        return round($monthlyAmount * $months, 2);
    }

    public function isValidMonthlyAmount(float $monthlyAmount): bool
    {
        return $monthlyAmount >= $this->min_monthly_payment;
    }

    public function getValidationError(float $monthlyAmount, int $months): ?string
    {
        if ($monthlyAmount < $this->min_monthly_payment) {
            return "Monthly payment must be at least BD {$this->min_monthly_payment}";
        }

        if ($months > $this->max_months) {
            return "Maximum duration is {$this->max_months} months";
        }

        return null;
    }
}
