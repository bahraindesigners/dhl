<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+2 months');
        $endDate = $this->faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s').' +8 hours');

        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(['draft', 'published', 'cancelled', 'completed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'timezone' => 'UTC',
            'location' => $this->faker->address,
            'location_details' => $this->faker->paragraph(),
            'featured' => $this->faker->boolean(20),
            'registration_enabled' => $this->faker->boolean(80),
            'capacity' => $this->faker->numberBetween(10, 200),
            'registered_count' => 0,
            'price' => $this->faker->randomFloat(2, 0, 500),
            'registration_starts_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'registration_ends_at' => $this->faker->dateTimeBetween('now', $startDate),
            'organizer' => $this->faker->company,
            'organizer_details' => $this->faker->paragraph(),
            'meta_title' => $this->faker->sentence(4),
            'meta_description' => $this->faker->sentence(8),
            'author' => $this->faker->name,
            'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the event is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Indicate that the event is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the event is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
        ]);
    }

    /**
     * Indicate that the event has high priority.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'high',
        ]);
    }
}
