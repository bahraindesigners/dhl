<?php

namespace Database\Seeders;

use App\Models\BoardMember;
use Illuminate\Database\Seeder;

class BoardMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create key leadership positions
        BoardMember::factory()->chairman()->create([
            'name' => [
                'en' => 'Ahmed Al-Rashid',
                'ar' => 'أحمد الراشد'
            ],
            'description' => [
                'en' => 'Ahmed brings over 25 years of leadership experience in the logistics and transportation industry. He has been instrumental in driving strategic growth and operational excellence.',
                'ar' => 'يتمتع أحمد بخبرة تزيد عن 25 عاماً في مجال القيادة في صناعة الخدمات اللوجستية والنقل. لقد لعب دوراً أساسياً في قيادة النمو الاستراتيجي والتميز التشغيلي.'
            ],
        ]);

        BoardMember::factory()->ceo()->create([
            'name' => [
                'en' => 'Sarah Johnson',
                'ar' => 'سارة جونسون'
            ],
            'description' => [
                'en' => 'Sarah is a dynamic leader with expertise in international business development and supply chain management. She holds an MBA from Wharton Business School.',
                'ar' => 'سارة قائدة ديناميكية تتمتع بخبرة في تطوير الأعمال الدولية وإدارة سلسلة التوريد. تحمل درجة الماجستير في إدارة الأعمال من كلية وارتون للأعمال.'
            ],
        ]);

        BoardMember::factory()->create([
            'name' => [
                'en' => 'Mohammed Hassan',
                'ar' => 'محمد حسن'
            ],
            'position' => [
                'en' => 'Chief Financial Officer',
                'ar' => 'المدير المالي'
            ],
            'description' => [
                'en' => 'Mohammed is a certified public accountant with extensive experience in financial planning and corporate governance in the GCC region.',
                'ar' => 'محمد محاسب قانوني معتمد يتمتع بخبرة واسعة في التخطيط المالي والحوكمة المؤسسية في منطقة دول مجلس التعاون الخليجي.'
            ],
            'sort_order' => 3,
            'is_active' => true,
        ]);

        BoardMember::factory()->create([
            'name' => [
                'en' => 'Dr. Fatima Al-Zahra',
                'ar' => 'د. فاطمة الزهراء'
            ],
            'position' => [
                'en' => 'Independent Director',
                'ar' => 'عضو مجلس إدارة مستقل'
            ],
            'description' => [
                'en' => 'Dr. Fatima is a renowned academic and business consultant specializing in digital transformation and organizational development.',
                'ar' => 'د. فاطمة أكاديمية ومستشارة أعمال مشهورة متخصصة في التحول الرقمي والتطوير التنظيمي.'
            ],
            'sort_order' => 4,
            'is_active' => true,
        ]);

        BoardMember::factory()->create([
            'name' => [
                'en' => 'James Wilson',
                'ar' => 'جيمس ويلسون'
            ],
            'position' => [
                'en' => 'Non-Executive Director',
                'ar' => 'عضو مجلس إدارة غير تنفيذي'
            ],
            'description' => [
                'en' => 'James brings international perspective with his background in European and North American markets. He has served on multiple corporate boards.',
                'ar' => 'يجلب جيمس منظوراً دولياً بخلفيته في الأسواق الأوروبية وأمريكا الشمالية. شغل مناصب في مجالس إدارة متعددة.'
            ],
            'sort_order' => 5,
            'is_active' => true,
        ]);

        // Create some additional board members with random data
        BoardMember::factory()->active()->count(3)->create();

        // Create one inactive member to test filtering
        BoardMember::factory()->inactive()->create([
            'name' => [
                'en' => 'Former Member',
                'ar' => 'عضو سابق'
            ],
            'position' => [
                'en' => 'Former Director',
                'ar' => 'مدير سابق'
            ],
            'description' => [
                'en' => 'This member is no longer active on the board.',
                'ar' => 'هذا العضو لم يعد نشطاً في مجلس الإدارة.'
            ],
        ]);
    }
}
