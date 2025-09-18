<?php

namespace Database\Seeders;

use App\Models\DownloadCategory;
use Illuminate\Database\Seeder;

class DownloadCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => ['en' => 'Forms', 'ar' => 'النماذج'],
                'description' => ['en' => 'Application forms and official documents', 'ar' => 'نماذج التطبيق والوثائق الرسمية'],
                'slug' => 'forms',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => ['en' => 'Policies', 'ar' => 'السياسات'],
                'description' => ['en' => 'Company policies and procedures', 'ar' => 'سياسات وإجراءات الشركة'],
                'slug' => 'policies',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => ['en' => 'Handbooks', 'ar' => 'الأدلة'],
                'description' => ['en' => 'Employee and operational handbooks', 'ar' => 'أدلة الموظفين والعمليات'],
                'slug' => 'handbooks',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => ['en' => 'Training Materials', 'ar' => 'المواد التدريبية'],
                'description' => ['en' => 'Training documents and resources', 'ar' => 'وثائق ومصادر التدريب'],
                'slug' => 'training-materials',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => ['en' => 'Reports', 'ar' => 'التقارير'],
                'description' => ['en' => 'Annual reports and studies', 'ar' => 'التقارير السنوية والدراسات'],
                'slug' => 'reports',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => ['en' => 'Guidelines', 'ar' => 'الإرشادات'],
                'description' => ['en' => 'Best practices and guidelines', 'ar' => 'أفضل الممارسات والإرشادات'],
                'slug' => 'guidelines',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => ['en' => 'Templates', 'ar' => 'القوالب'],
                'description' => ['en' => 'Document templates and forms', 'ar' => 'قوالب الوثائق والنماذج'],
                'slug' => 'templates',
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($categories as $category) {
            DownloadCategory::create($category);
        }
    }
}
