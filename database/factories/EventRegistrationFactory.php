<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventRegistration>
 */
class EventRegistrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = EventRegistration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $registeredAt = $this->faker->dateTimeBetween('-2 months', 'now');
        $status = $this->faker->randomElement(['pending', 'confirmed', 'cancelled']);

        $confirmedAt = null;
        $cancelledAt = null;

        if ($status === 'confirmed') {
            $confirmedAt = $this->faker->dateTimeBetween($registeredAt, 'now');
        } elseif ($status === 'cancelled') {
            $cancelledAt = $this->faker->dateTimeBetween($registeredAt, 'now');
        }

        return [
            'event_id' => Event::factory(),
            'user_id' => $this->faker->boolean(80) ? User::factory() : null,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'special_requirements' => $this->faker->optional()->sentence,
            'status' => $status,
            'registered_at' => $registeredAt,
            'confirmed_at' => $confirmedAt,
            'cancelled_at' => $cancelledAt,
            'amount_paid' => $this->faker->randomFloat(2, 0, 500),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer', 'cash']),
            'payment_reference' => $this->faker->uuid,
            'registration_data' => json_encode([
                'emergency_contact' => $this->faker->name,
                'dietary_requirements' => $this->faker->optional()->sentence,
            ]),
            'admin_notes' => $this->faker->optional()->sentence,
        ];
    }

    /**
     * Indicate that the registration is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'payment_status' => 'paid',
        ]);
    }

    /**
     * Indicate that the registration is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'confirmed_at' => null,
            'payment_status' => 'pending',
        ]);
    }

    /**
     * Indicate that the registration is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'payment_status' => 'refunded',
        ]);
    }

    /**
     * Indicate that the registration is for a guest (no user account).
     */
    public function guest(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
        ]);
    }
}
