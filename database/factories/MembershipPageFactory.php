<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MembershipPage>
 */
class MembershipPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'how_to_join' => [
                'en' => '<h2>How to Join Our Union</h2><p>Welcome to the DHL Bahrain Trade Union! Joining our union is simple and beneficial.</p>',
                'ar' => '<h2>كيفية الانضمام إلى نقابتنا</h2><p>مرحباً بكم في نقابة موظفي دي إتش إل البحرين! الانضمام إلى نقابتنا بسيط ومفيد.</p>',
            ],
            'union_benefits' => [
                'en' => '<h2>Union Benefits</h2><p>As a member, you will enjoy various benefits and protections.</p>',
                'ar' => '<h2>مزايا النقابة</h2><p>كعضو، ستستفيد من مزايا وحماية متنوعة.</p>',
            ],
            'enable_member_form' => true,
            'notification_email' => $this->faker->safeEmail(),
            'is_active' => true,
        ];
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
