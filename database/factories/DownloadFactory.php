<?php

namespace Database\Factories;

use App\Models\Download;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Download>
 */
class DownloadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['forms', 'policies', 'handbooks', 'training', 'reports', 'guides', 'templates', 'other'];
        $accessLevels = ['public', 'employees', 'managers', 'admin'];

        $titleTemplates = [
            'forms' => [
                'en' => ['Employee Request Form', 'Leave Application', 'Expense Report Form', 'Performance Review Form'],
                'ar' => ['نموذج طلب الموظف', 'طلب إجازة', 'نموذج تقرير المصاريف', 'نموذج تقييم الأداء'],
            ],
            'policies' => [
                'en' => ['Code of Conduct', 'HR Policy Manual', 'Safety Guidelines', 'IT Security Policy'],
                'ar' => ['قواعد السلوك', 'دليل سياسات الموارد البشرية', 'إرشادات السلامة', 'سياسة أمن تكنولوجيا المعلومات'],
            ],
            'handbooks' => [
                'en' => ['Employee Handbook', 'New Hire Guide', 'Benefits Overview', 'Company Directory'],
                'ar' => ['دليل الموظف', 'دليل التوظيف الجديد', 'نظرة عامة على المزايا', 'دليل الشركة'],
            ],
            'training' => [
                'en' => ['Onboarding Training', 'Skills Development', 'Leadership Workshop', 'Technical Training'],
                'ar' => ['تدريب التأهيل', 'تطوير المهارات', 'ورشة القيادة', 'التدريب التقني'],
            ],
            'reports' => [
                'en' => ['Annual Report', 'Financial Summary', 'Performance Metrics', 'Market Analysis'],
                'ar' => ['التقرير السنوي', 'الملخص المالي', 'مقاييس الأداء', 'تحليل السوق'],
            ],
            'guides' => [
                'en' => ['User Manual', 'Setup Guide', 'Troubleshooting', 'Best Practices'],
                'ar' => ['دليل المستخدم', 'دليل الإعداد', 'استكشاف الأخطاء', 'أفضل الممارسات'],
            ],
        ];

        $category = $this->faker->randomElement($categories);
        $titleIndex = $this->faker->numberBetween(0, 3);

        return [
            'title' => [
                'en' => $titleTemplates[$category]['en'][$titleIndex] ?? $this->faker->sentence(3),
                'ar' => $titleTemplates[$category]['ar'][$titleIndex] ?? 'عنوان باللغة العربية '.$this->faker->numberBetween(1, 100),
            ],
            'description' => [
                'en' => $this->faker->paragraph(2),
                'ar' => 'وصف باللغة العربية. '.$this->faker->sentence(10),
            ],
            'category' => $category,
            'access_level' => $this->faker->randomElement($accessLevels),
            'is_active' => $this->faker->boolean(85), // 85% chance of being active
            'sort_order' => $this->faker->numberBetween(1, 100),
            'download_count' => $this->faker->numberBetween(0, 500),
            'file_size' => $this->faker->numberBetween(50000, 10000000), // 50KB to 10MB
            'file_type' => $this->faker->randomElement([
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/plain',
                'image/jpeg',
                'image/png',
            ]),
        ];
    }

    /**
     * Indicate that the download is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the download is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create a download with a specific category.
     */
    public function category(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }

    /**
     * Create a public download.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'access_level' => 'public',
        ]);
    }

    /**
     * Create an employees-only download.
     */
    public function employeesOnly(): static
    {
        return $this->state(fn (array $attributes) => [
            'access_level' => 'employees',
        ]);
    }
}
