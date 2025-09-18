<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FAQCategory>
 */
class FAQCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $englishName = $this->faker->unique()->words(2, true);
        $arabicName = 'فئة '.$this->faker->word();

        return [
            'name' => [
                'en' => ucwords($englishName),
                'ar' => $arabicName,
            ],
            'description' => [
                'en' => "Frequently asked questions about {$englishName}",
                'ar' => "الأسئلة الشائعة حول {$arabicName}",
            ],
            'slug' => str($englishName)->slug().'-'.$this->faker->randomNumber(4),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
