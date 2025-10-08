<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => ['en' => 'Conferences', 'ar' => 'المؤتمرات'],
                'description' => ['en' => 'Professional conferences and industry gatherings', 'ar' => 'المؤتمرات المهنية واللقاءات الصناعية'],
                'receiver_emails' => ['conferences@dhl.com'],
                'sort_order' => 1,
            ],
            [
                'name' => ['en' => 'Workshops', 'ar' => 'ورش العمل'],
                'description' => ['en' => 'Interactive workshops and hands-on learning experiences', 'ar' => 'ورش العمل التفاعلية وتجارب التعلم العملي'],
                'receiver_emails' => ['workshops@dhl.com'],
                'sort_order' => 2,
            ],
            [
                'name' => ['en' => 'Training Sessions', 'ar' => 'الدورات التدريبية'],
                'description' => ['en' => 'Professional training and skill development sessions', 'ar' => 'التدريب المهني وجلسات تطوير المهارات'],
                'receiver_emails' => ['training@dhl.com'],
                'sort_order' => 3,
            ],
            [
                'name' => ['en' => 'Networking Events', 'ar' => 'فعاليات التواصل'],
                'description' => ['en' => 'Networking opportunities and professional meetups', 'ar' => 'فرص التواصل واللقاءات المهنية'],
                'receiver_emails' => ['networking@dhl.com'],
                'sort_order' => 4,
            ],
            [
                'name' => ['en' => 'Product Launches', 'ar' => 'إطلاق المنتجات'],
                'description' => ['en' => 'New product launches and service announcements', 'ar' => 'إطلاق المنتجات الجديدة وإعلانات الخدمات'],
                'receiver_emails' => ['products@dhl.com'],
                'sort_order' => 5,
            ],
            [
                'name' => ['en' => 'Webinars', 'ar' => 'الندوات الإلكترونية'],
                'description' => ['en' => 'Online seminars and virtual presentations', 'ar' => 'الندوات الإلكترونية والعروض التقديمية الافتراضية'],
                'receiver_emails' => ['webinars@dhl.com'],
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $categoryData) {
            \App\Models\EventCategory::create($categoryData);
        }

        // Create some additional random categories
        \App\Models\EventCategory::factory()->active()->count(3)->create();
    }
}
