<?php

namespace Database\Factories;

use App\LoanStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnionLoan>
 */
class UnionLoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'months' => $this->faker->numberBetween(6, 24),
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
     * Indicate that the loan is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LoanStatus::Pending,
            'rejected_reason' => null,
        ]);
    }

    /**
     * Indicate that the loan is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LoanStatus::Approved,
            'rejected_reason' => null,
        ]);
    }

    /**
     * Indicate that the loan is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => LoanStatus::Rejected,
            'rejected_reason' => $this->faker->sentence(),
        ]);
    }
}
