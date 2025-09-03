<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Technology',
                    'ar' => 'التكنولوجيا'
                ],
                'slug' => [
                    'en' => 'technology',
                    'ar' => 'التكنولوجيا'
                ],
                'description' => [
                    'en' => 'Latest news and updates in technology',
                    'ar' => 'آخر الأخبار والتحديثات في التكنولوجيا'
                ],
                'color' => '#3B82F6',
                'icon' => 'cpu-chip',
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'name' => [
                    'en' => 'Business',
                    'ar' => 'الأعمال'
                ],
                'slug' => [
                    'en' => 'business',
                    'ar' => 'الأعمال'
                ],
                'description' => [
                    'en' => 'Business insights and market analysis',
                    'ar' => 'رؤى الأعمال وتحليل السوق'
                ],
                'color' => '#10B981',
                'icon' => 'briefcase',
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'name' => [
                    'en' => 'Health',
                    'ar' => 'الصحة'
                ],
                'slug' => [
                    'en' => 'health',
                    'ar' => 'الصحة'
                ],
                'description' => [
                    'en' => 'Health tips and medical news',
                    'ar' => 'نصائح صحية وأخبار طبية'
                ],
                'color' => '#EF4444',
                'icon' => 'heart',
                'sort_order' => 3,
                'status' => 'active',
            ],
            [
                'name' => [
                    'en' => 'Lifestyle',
                    'ar' => 'نمط الحياة'
                ],
                'slug' => [
                    'en' => 'lifestyle',
                    'ar' => 'نمط-الحياة'
                ],
                'description' => [
                    'en' => 'Lifestyle and entertainment content',
                    'ar' => 'محتوى نمط الحياة والترفيه'
                ],
                'color' => '#8B5CF6',
                'icon' => 'star',
                'sort_order' => 4,
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::create($category);
        }
    }
}
