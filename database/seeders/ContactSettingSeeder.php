<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Illuminate\Database\Seeder;

class ContactSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the singleton contact settings record only if it doesn't exist
        if (ContactSetting::count() === 0) {
            ContactSetting::create([
                'notification_emails' => ['admin@dhlunion.bh'],
                'instagram_url' => 'https://instagram.com/dhlunion',
                'linkedin_url' => 'https://linkedin.com/company/dhlunion',
                'x_url' => 'https://x.com/dhlunion',
                'office_address' => [
                    'en' => 'DHL Bahrain Trade Union Office<br>Building 123, Industrial Area<br>Manama, Kingdom of Bahrain',
                    'ar' => 'مكتب نقابة موظفي دي إتش إل البحرين<br>مبنى 123، المنطقة الصناعية<br>المنامة، مملكة البحرين',
                ],
                'phone_numbers' => [
                    'en' => '+973 1234 5678',
                    'ar' => '+973 1234 5678',
                ],
                'office_hours' => [
                    'en' => 'Sunday - Thursday: 8:00 AM - 5:00 PM<br>Friday - Saturday: Closed',
                    'ar' => 'الأحد - الخميس: 8:00 صباحاً - 5:00 مساءً<br>الجمعة - السبت: مغلق',
                ],
                'content' => [
                    'en' => '<p>For urgent matters outside office hours, please send an email and we will respond as soon as possible.</p>',
                    'ar' => '<p>للأمور العاجلة خارج ساعات العمل، يرجى إرسال بريد إلكتروني وسنرد في أقرب وقت ممكن.</p>',
                ],
                'is_active' => true,
            ]);
        }
    }
}
