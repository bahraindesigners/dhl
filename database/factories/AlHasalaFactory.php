<?php

namespace Database\Factories;

use App\LoanStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AlHasala>
 */
class AlHasalaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $monthlyAmount = $this->faker->randomFloat(2, 50, 500);
        $months = $this->faker->numberBetween(6, 24);

        return [
            'user_id' => User::factory(),
            'monthly_amount' => $monthlyAmount,
            'months' => $months,
            'total_amount' => $monthlyAmount * $months,
            'status' => $this->faker->randomElement([
                LoanStatus::Pending,
                LoanStatus::Approved,
                LoanStatus::Rejected,
            ]),
            'note' => $this->faker->optional()->sentence(),
            'rejected_reason' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the Al Hasala is pending.
     */
    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => LoanStatus::Pending,
            'rejected_reason' => null,
        ]);
    }

    /**
     * Indicate that the Al Hasala is approved.
     */
    public function approved(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => LoanStatus::Approved,
            'rejected_reason' => null,
        ]);
    }

    /**
     * Indicate that the Al Hasala is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => LoanStatus::Rejected,
            'rejected_reason' => $this->faker->sentence(),
        ]);
    }
}
