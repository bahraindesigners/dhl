<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FAQ>
 */
class FAQFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = array_keys(\App\Models\FAQ::getCategories());
        $questionTemplates = [
            'How do I %s?',
            'What is %s?',
            'Can I %s?',
            'Where can I find %s?',
            'When does %s happen?',
            'Why is %s important?',
        ];

        $question = sprintf(
            $this->faker->randomElement($questionTemplates),
            $this->faker->words(2, true)
        );

        return [
            'question' => [
                'en' => $question,
                'ar' => 'ما هي '.$this->faker->words(3, true).'؟',
            ],
            'answer' => [
                'en' => $this->faker->paragraphs(2, true),
                'ar' => $this->faker->paragraphs(2, true),
            ],
            'category' => $this->faker->randomElement($categories),
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_featured' => $this->faker->boolean(20), // 20% chance
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'meta_title' => [
                'en' => $question.' - FAQ',
                'ar' => 'الأسئلة الشائعة - '.$this->faker->words(2, true),
            ],
            'meta_description' => [
                'en' => 'Find answers to frequently asked questions about '.$this->faker->words(3, true),
                'ar' => 'اعثر على إجابات للأسئلة الشائعة حول '.$this->faker->words(3, true),
            ],
            'slug' => $this->faker->unique()->slug(3),
            'published_at' => $this->faker->boolean(80) ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
        ];
    }

    /**
     * Indicate that the FAQ is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'status' => 'active',
            'published_at' => now(),
        ]);
    }

    /**
     * Indicate that the FAQ is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'published_at' => now(),
        ]);
    }
}
