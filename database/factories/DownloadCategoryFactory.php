<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DownloadCategory>
 */
class DownloadCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'forms' => ['Forms', 'النماذج'],
            'policies' => ['Policies', 'السياسات'],
            'handbooks' => ['Handbooks', 'الأدلة'],
            'training' => ['Training Materials', 'المواد التدريبية'],
            'reports' => ['Reports', 'التقارير'],
            'guidelines' => ['Guidelines', 'الإرشادات'],
            'templates' => ['Templates', 'القوالب'],
        ];

        $category = $this->faker->randomElement(array_keys($categories));
        [$nameEn, $nameAr] = $categories[$category];

        return [
            'name' => [
                'en' => $nameEn,
                'ar' => $nameAr,
            ],
            'description' => [
                'en' => $this->faker->sentence(),
                'ar' => 'وصف تصنيف التحميلات باللغة العربية.',
            ],
            'slug' => $category.'-'.$this->faker->unique()->randomNumber(5),
            'is_active' => $this->faker->boolean(80),
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
