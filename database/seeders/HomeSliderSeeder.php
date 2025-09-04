<?php

namespace Database\Seeders;

use App\Models\HomeSlider;
use Illuminate\Database\Seeder;

class HomeSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample home slider items
        $sliders = [
            [
                'title' => [
                    'en' => 'Welcome to Our Platform',
                    'ar' => 'مرحباً بكم في منصتنا',
                ],
                'subtitle' => [
                    'en' => 'Discover Amazing Solutions',
                    'ar' => 'اكتشف حلولاً مذهلة',
                ],
                'description' => [
                    'en' => 'Join thousands of satisfied customers who trust our innovative solutions for their business needs.',
                    'ar' => 'انضم إلى آلاف العملاء الراضين الذين يثقون في حلولنا المبتكرة لاحتياجات أعمالهم.',
                ],
                'button_text' => [
                    'en' => 'Get Started',
                    'ar' => 'ابدأ الآن',
                ],
                'button_url' => '/contact',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => [
                    'en' => 'Innovative Services',
                    'ar' => 'خدمات مبتكرة',
                ],
                'subtitle' => [
                    'en' => 'Tailored for Your Success',
                    'ar' => 'مصممة خصيصاً لنجاحك',
                ],
                'description' => [
                    'en' => 'Experience cutting-edge technology and personalized service that drives results for your organization.',
                    'ar' => 'اختبر التكنولوجيا المتطورة والخدمة الشخصية التي تحقق النتائج لمؤسستك.',
                ],
                'button_text' => [
                    'en' => 'Learn More',
                    'ar' => 'اعرف المزيد',
                ],
                'button_url' => '/services',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => [
                    'en' => 'Excellence in Quality',
                    'ar' => 'التميز في الجودة',
                ],
                'subtitle' => [
                    'en' => 'Committed to Your Growth',
                    'ar' => 'ملتزمون بنموك',
                ],
                'description' => [
                    'en' => 'Our commitment to excellence ensures you receive the highest quality service and support.',
                    'ar' => 'التزامنا بالتميز يضمن حصولك على أعلى جودة من الخدمة والدعم.',
                ],
                'button_text' => [
                    'en' => 'Contact Us',
                    'ar' => 'تواصل معنا',
                ],
                'button_url' => '/contact',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($sliders as $sliderData) {
            HomeSlider::create($sliderData);
        }
    }
}
