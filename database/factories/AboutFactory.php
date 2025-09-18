<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\About>
 */
class AboutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => [
                'en' => 'About Us',
                'ar' => 'معلومات عنا',
            ],
            'content' => [
                'en' => '<h2>Welcome to Our Organization</h2><p>We are dedicated to excellence and innovation in everything we do. Our mission is to provide outstanding services and make a positive impact in our community.</p><h3>Our Vision</h3><p>To be a leading organization that drives positive change and delivers exceptional value to all stakeholders.</p><h3>Our Values</h3><ul><li>Excellence in all our endeavors</li><li>Integrity and transparency</li><li>Innovation and continuous improvement</li><li>Respect for all individuals</li><li>Commitment to our community</li></ul>',
                'ar' => '<h2>مرحباً بكم في منظمتنا</h2><p>نحن ملتزمون بالتميز والابتكار في كل ما نقوم به. مهمتنا هي تقديم خدمات متميزة وإحداث تأثير إيجابي في مجتمعنا.</p><h3>رؤيتنا</h3><p>أن نكون منظمة رائدة تقود التغيير الإيجابي وتقدم قيمة استثنائية لجميع أصحاب المصلحة.</p><h3>قيمنا</h3><ul><li>التميز في جميع مساعينا</li><li>النزاهة والشفافية</li><li>الابتكار والتحسين المستمر</li><li>الاحترام لجميع الأفراد</li><li>الالتزام تجاه مجتمعنا</li></ul>',
            ],
            'show_board_section' => $this->faker->boolean(70),
            'board_section_title' => [
                'en' => 'Our Leadership Team',
                'ar' => 'فريق القيادة',
            ],
            'board_section_description' => [
                'en' => 'Meet the dedicated professionals who guide our organization with their expertise and vision.',
                'ar' => 'تعرف على المحترفين المتفانين الذين يوجهون منظمتنا بخبرتهم ورؤيتهم.',
            ],
            'is_active' => $this->faker->boolean(90),
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
