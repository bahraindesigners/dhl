<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HomeSlider>
 */
class HomeSliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => [
                'en' => fake()->text(50),
                'ar' => 'عنوان الشريحة '.fake()->numberBetween(1, 100),
            ],
            'subtitle' => [
                'en' => fake()->text(100),
                'ar' => 'عنوان فرعي للشريحة '.fake()->numberBetween(1, 100),
            ],
            'description' => [
                'en' => fake()->text(200),
                'ar' => 'وصف الشريحة '.fake()->text(100),
            ],
            'button_text' => [
                'en' => fake()->randomElement(['Learn More', 'Get Started', 'Contact Us', 'Discover']),
                'ar' => fake()->randomElement(['اعرف المزيد', 'ابدأ الآن', 'تواصل معنا', 'اكتشف']),
            ],
            'button_url' => fake()->randomElement(['/about', '/contact', '/services', '/products']),
            'is_active' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
