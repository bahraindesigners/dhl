<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactSetting>
 */
class ContactSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notification_email' => $this->faker->safeEmail(),
            'instagram_url' => 'https://instagram.com/example',
            'linkedin_url' => 'https://linkedin.com/company/example',
            'x_url' => 'https://x.com/example',
            'office_address' => [
                'en' => $this->faker->address(),
                'ar' => 'عنوان مكتب تجريبي',
            ],
            'phone_numbers' => [
                'en' => $this->faker->phoneNumber(),
                'ar' => '+973 1234 5678',
            ],
            'office_hours' => [
                'en' => 'Monday - Friday: 9:00 AM - 5:00 PM',
                'ar' => 'الإثنين - الجمعة: 9:00 صباحاً - 5:00 مساءً',
            ],
            'content' => [
                'en' => $this->faker->paragraph(),
                'ar' => 'محتوى تجريبي باللغة العربية',
            ],
            'is_active' => true,
        ];
    }

    /**
     * Indicate that no notification email should be set.
     */
    public function withoutNotifications(): static
    {
        return $this->state(fn (array $attributes) => [
            'notification_email' => null,
        ]);
    }

    /**
     * Indicate that no notification email should be set.
     */
    public function withoutNotificationEmail(): static
    {
        return $this->state(fn (array $attributes) => [
            'notification_email' => null,
        ]);
    }
}
