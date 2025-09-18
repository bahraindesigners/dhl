<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoardMember>
 */
class BoardMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            'Chairman',
            'Vice Chairman',
            'Chief Executive Officer',
            'Chief Financial Officer',
            'Chief Operating Officer',
            'Chief Technology Officer',
            'Board Member',
            'Independent Director',
            'Executive Director',
            'Non-Executive Director',
        ];

        $arabicPositions = [
            'رئيس مجلس الإدارة',
            'نائب رئيس مجلس الإدارة',
            'الرئيس التنفيذي',
            'المدير المالي',
            'مدير العمليات',
            'مدير التكنولوجيا',
            'عضو مجلس إدارة',
            'عضو مجلس إدارة مستقل',
            'عضو مجلس إدارة تنفيذي',
            'عضو مجلس إدارة غير تنفيذي',
        ];

        $name = $this->faker->name();
        $position = $this->faker->randomElement($positions);
        $positionIndex = array_search($position, $positions);
        $arabicPosition = $arabicPositions[$positionIndex] ?? 'عضو مجلس إدارة';

        return [
            'name' => [
                'en' => $name,
                'ar' => $this->faker->randomElement([
                    'أحمد محمد الخليل',
                    'فاطمة علي الزهراني',
                    'محمد عبدالله السعيد',
                    'نورا سعد العتيبي',
                    'خالد حسن المطيري',
                    'سارة يوسف القحطاني',
                    'عبدالرحمن طارق النجار',
                    'ليلى عامر الشمري',
                    'سلطان فهد العجمي',
                    'رنا ماجد الرشيد'
                ]),
            ],
            'position' => [
                'en' => $position,
                'ar' => $arabicPosition,
            ],
            'description' => [
                'en' => $this->faker->paragraph(3),
                'ar' => 'تتمتع بخبرة واسعة في مجال الأعمال والإدارة، وقد شغلت مناصب قيادية في عدة شركات كبرى. حاصلة على درجة الماجستير في إدارة الأعمال من جامعة مرموقة، وتتمتع بسمعة طيبة في القطاع.',
            ],
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }

    /**
     * Create an active board member.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Create an inactive board member.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create a chairman.
     */
    public function chairman(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => [
                'en' => 'Chairman',
                'ar' => 'رئيس مجلس الإدارة',
            ],
            'sort_order' => 1,
        ]);
    }

    /**
     * Create a CEO.
     */
    public function ceo(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => [
                'en' => 'Chief Executive Officer',
                'ar' => 'الرئيس التنفيذي',
            ],
            'sort_order' => 2,
        ]);
    }
}
