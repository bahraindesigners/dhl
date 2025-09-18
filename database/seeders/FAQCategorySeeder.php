<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FAQCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => ['en' => 'General', 'ar' => 'عام'],
                'description' => ['en' => 'General questions and information', 'ar' => 'أسئلة ومعلومات عامة'],
                'slug' => 'general',
                'sort_order' => 1,
            ],
            [
                'name' => ['en' => 'Events', 'ar' => 'الفعاليات'],
                'description' => ['en' => 'Questions about events and activities', 'ar' => 'أسئلة حول الفعاليات والأنشطة'],
                'slug' => 'events',
                'sort_order' => 2,
            ],
            [
                'name' => ['en' => 'Registration', 'ar' => 'التسجيل'],
                'description' => ['en' => 'Event registration and sign-up process', 'ar' => 'تسجيل الفعاليات وعملية التسجيل'],
                'slug' => 'registration',
                'sort_order' => 3,
            ],
            [
                'name' => ['en' => 'Payment', 'ar' => 'الدفع'],
                'description' => ['en' => 'Payment methods and billing questions', 'ar' => 'طرق الدفع وأسئلة الفواتير'],
                'slug' => 'payment',
                'sort_order' => 4,
            ],
            [
                'name' => ['en' => 'Technical Support', 'ar' => 'الدعم الفني'],
                'description' => ['en' => 'Technical issues and platform support', 'ar' => 'المشاكل التقنية ودعم المنصة'],
                'slug' => 'technical-support',
                'sort_order' => 5,
            ],
            [
                'name' => ['en' => 'Account', 'ar' => 'الحساب'],
                'description' => ['en' => 'User account and profile management', 'ar' => 'إدارة حساب المستخدم والملف الشخصي'],
                'slug' => 'account',
                'sort_order' => 6,
            ],
            [
                'name' => ['en' => 'Policies', 'ar' => 'السياسات'],
                'description' => ['en' => 'Terms of service and privacy policies', 'ar' => 'شروط الخدمة وسياسات الخصوصية'],
                'slug' => 'policies',
                'sort_order' => 7,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\FAQCategory::create($category);
        }
    }
}
