<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
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
                'en' => $this->faker->sentence(3),
                'ar' => 'عرض ' . $this->faker->randomElement(['خاص', 'مميز', 'استثنائي', 'محدود', 'رائع']),
            ],
            'description' => [
                'en' => $this->faker->sentence(8),
                'ar' => 'وصف العرض: ' . $this->faker->realText(100),
            ],
            'company_name' => [
                'en' => $this->faker->company(),
                'ar' => 'شركة ' . $this->faker->randomElement(['الخليج', 'النور', 'الأمل', 'التقدم', 'الازدهار']),
            ],
            'discount' => $this->faker->randomElement(['10%', '20%', '25%', '30%', '50%', '$10', '$25', '$50', 'Buy 1 Get 1']),
            'offer_description' => [
                'en' => '<p>' . $this->faker->paragraph(4) . '</p><p>' . $this->faker->paragraph(3) . '</p>',
                'ar' => '<p>تفاصيل العرض: ' . $this->faker->realText(200) . '</p><p>شروط وأحكام العرض تطبق.</p>',
            ],
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
