<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'title' => [
                'en' => 'About DHL Organization',
                'ar' => 'حول منظمة دي إتش إل',
            ],
            'content' => [
                'en' => '<h2>Welcome to DHL</h2><p>We are a premier logistics and delivery organization committed to excellence in service delivery and customer satisfaction. Our mission is to connect people and improve lives through reliable, efficient, and innovative logistics solutions.</p><h3>Our Mission</h3><p>To be the leading logistics company that enables global commerce and drives economic growth worldwide.</p><h3>Our Values</h3><ul><li><strong>Excellence:</strong> We strive for the highest standards in everything we do</li><li><strong>Respect:</strong> We value diversity and treat everyone with dignity</li><li><strong>Results:</strong> We deliver on our promises and exceed expectations</li><li><strong>Customer Focus:</strong> Our customers are at the heart of our business</li></ul><h3>Our Services</h3><p>We provide comprehensive logistics solutions including express delivery, freight transportation, supply chain management, and e-commerce solutions.</p>',
                'ar' => '<h2>مرحباً بكم في دي إتش إل</h2><p>نحن منظمة لوجستية وتوصيل رائدة ملتزمة بالتميز في تقديم الخدمات ورضا العملاء. مهمتنا هي ربط الناس وتحسين الحياة من خلال حلول لوجستية موثوقة وفعالة ومبتكرة.</p><h3>مهمتنا</h3><p>أن نكون شركة اللوجستيات الرائدة التي تمكن التجارة العالمية وتقود النمو الاقتصادي في جميع أنحاء العالم.</p><h3>قيمنا</h3><ul><li><strong>التميز:</strong> نسعى لأعلى المعايير في كل ما نقوم به</li><li><strong>الاحترام:</strong> نقدر التنوع ونعامل الجميع بكرامة</li><li><strong>النتائج:</strong> نحقق وعودنا ونتجاوز التوقعات</li><li><strong>التركيز على العملاء:</strong> عملاؤنا في قلب أعمالنا</li></ul><h3>خدماتنا</h3><p>نوفر حلول لوجستية شاملة تشمل التوصيل السريع ونقل البضائع وإدارة سلسلة التوريد وحلول التجارة الإلكترونية.</p>',
            ],
            'show_board_section' => true,
            'board_section_title' => [
                'en' => 'Leadership Team',
                'ar' => 'فريق القيادة',
            ],
            'board_section_description' => [
                'en' => 'Our experienced leadership team brings together decades of industry expertise to guide DHL towards continued growth and innovation.',
                'ar' => 'يجمع فريق القيادة ذو الخبرة لدينا عقود من الخبرة في الصناعة لتوجيه دي إتش إل نحو النمو المستمر والابتكار.',
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
