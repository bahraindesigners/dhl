<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventCategory>
 */
class EventCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ['en' => 'Conferences', 'ar' => 'المؤتمرات'],
            ['en' => 'Workshops', 'ar' => 'ورش العمل'],
            ['en' => 'Training Sessions', 'ar' => 'الدورات التدريبية'],
            ['en' => 'Networking Events', 'ar' => 'فعاليات التواصل'],
            ['en' => 'Product Launches', 'ar' => 'إطلاق المنتجات'],
            ['en' => 'Webinars', 'ar' => 'الندوات الإلكترونية'],
            ['en' => 'Corporate Events', 'ar' => 'الفعاليات المؤسسية'],
            ['en' => 'Trade Shows', 'ar' => 'المعارض التجارية'],
        ];

        $descriptions = [
            ['en' => 'Professional conferences and industry gatherings', 'ar' => 'المؤتمرات المهنية واللقاءات الصناعية'],
            ['en' => 'Interactive workshops and hands-on learning experiences', 'ar' => 'ورش العمل التفاعلية وتجارب التعلم العملي'],
            ['en' => 'Professional training and skill development sessions', 'ar' => 'التدريب المهني وجلسات تطوير المهارات'],
            ['en' => 'Networking opportunities for professionals', 'ar' => 'فرص التواصل للمهنيين'],
        ];

        $category = $this->faker->randomElement($categories);
        $description = $this->faker->randomElement($descriptions);

        return [
            'name' => $category,
            'description' => $description,
            'receiver_emails' => [
                $this->faker->companyEmail(),
                $this->faker->companyEmail(),
            ],
            'is_active' => $this->faker->boolean(85), // 85% active
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }

    /**
     * Indicate that the category is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
