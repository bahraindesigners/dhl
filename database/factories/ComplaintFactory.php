<?php

namespace Database\Factories;

use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Complaint>
 */
class ComplaintFactory extends Factory
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
            'member_profile_id' => MemberProfile::factory(),
            'subject' => fake()->sentence(),
            'description' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement(['pending', 'in_progress', 'resolved', 'closed']),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'urgent']),
            'admin_notes' => fake()->optional()->paragraph(),
            'resolved_at' => fake()->optional()->dateTime(),
        ];
    }
}
