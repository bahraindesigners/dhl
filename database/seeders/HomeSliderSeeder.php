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
        // Create sample home slider items based on DHL Trade Union design
        $sliders = [
            [
                'title' => [
                    'en' => 'Welcome to the DHL Bahraini Trade Union',
                    'ar' => 'مرحباً بكم في نقابة دي إتش إل البحرينية',
                ],
                'subtitle' => [
                    'en' => 'Unity • Strength • Progress',
                    'ar' => 'الوحدة • القوة • التقدم',
                ],
                'description' => [
                    'en' => 'Protecting employee rights, ensuring transparency, and building solidarity since 2005.',
                    'ar' => 'حماية حقوق الموظفين وضمان الشفافية وبناء التضامن منذ عام 2005.',
                ],
                'button_text' => [
                    'en' => 'Submit a Complaint',
                    'ar' => 'تقديم شكوى',
                ],
                'button_url' => '/complaints',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => [
                    'en' => 'Building a Stronger Workplace Together',
                    'ar' => 'بناء مكان عمل أقوى معاً',
                ],
                'subtitle' => [
                    'en' => 'Your Voice Matters',
                    'ar' => 'صوتك مهم',
                ],
                'description' => [
                    'en' => 'Join us in creating a fair and supportive work environment where every employee is valued and heard.',
                    'ar' => 'انضم إلينا في خلق بيئة عمل عادلة وداعمة حيث يُقدر كل موظف ويُسمع صوته.',
                ],
                'button_text' => [
                    'en' => 'Contact the Union',
                    'ar' => 'تواصل مع النقابة',
                ],
                'button_url' => '/contact',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => [
                    'en' => 'Standing Together for Your Rights',
                    'ar' => 'نقف معاً من أجل حقوقكم',
                ],
                'subtitle' => [
                    'en' => 'Solidarity in Action',
                    'ar' => 'التضامن في العمل',
                ],
                'description' => [
                    'en' => 'We advocate for fair wages, safe working conditions, and equal opportunities for all DHL employees.',
                    'ar' => 'ندافع عن الأجور العادلة وظروف العمل الآمنة والفرص المتكافئة لجميع موظفي دي إتش إل.',
                ],
                'button_text' => [
                    'en' => 'Learn More',
                    'ar' => 'اعرف المزيد',
                ],
                'button_url' => '/about',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($sliders as $sliderData) {
            HomeSlider::create($sliderData);
        }
    }
}
