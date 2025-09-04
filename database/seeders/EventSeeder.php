<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => [
                    'en' => 'Digital Marketing Summit 2025',
                    'ar' => 'قمة التسويق الرقمي 2025',
                ],
                'slug' => [
                    'en' => 'digital-marketing-summit-2025',
                    'ar' => 'قمة-التسويق-الرقمي-2025',
                ],
                'description' => [
                    'en' => 'Join industry leaders for the most comprehensive digital marketing event of the year.',
                    'ar' => 'انضم إلى قادة الصناعة لأشمل فعالية للتسويق الرقمي في السنة.',
                ],
                'content' => [
                    'en' => '<h2>About the Summit</h2><p>This comprehensive event will cover the latest trends in digital marketing, including social media strategies, SEO, content marketing, and emerging technologies.</p><h3>What You\'ll Learn</h3><ul><li>Advanced social media marketing techniques</li><li>SEO strategies for 2025</li><li>Content marketing best practices</li><li>AI and automation in marketing</li></ul>',
                    'ar' => '<h2>حول القمة</h2><p>ستغطي هذه الفعالية الشاملة أحدث الاتجاهات في التسويق الرقمي، بما في ذلك استراتيجيات وسائل التواصل الاجتماعي وتحسين محركات البحث وتسويق المحتوى والتقنيات الناشئة.</p><h3>ما ستتعلمه</h3><ul><li>تقنيات متقدمة لتسويق وسائل التواصل الاجتماعي</li><li>استراتيجيات تحسين محركات البحث لعام 2025</li><li>أفضل ممارسات تسويق المحتوى</li><li>الذكاء الاصطناعي والأتمتة في التسويق</li></ul>',
                ],
                'start_date' => Carbon::now()->addDays(30)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(30)->setTime(17, 0),
                'timezone' => 'Asia/Kuwait',
                'status' => 'published',
                'priority' => 'high',
                'featured' => true,
                'location' => 'Kuwait International Convention Center',
                'location_details' => 'Hall A, 2nd Floor, Mishref, Kuwait City',
                'capacity' => 200,
                'registration_enabled' => true,
                'registration_starts_at' => Carbon::now(),
                'registration_ends_at' => Carbon::now()->addDays(25),
                'price' => 299.00,
                'organizer' => [
                    'en' => 'Digital Innovation Hub',
                    'ar' => 'مركز الابتكار الرقمي',
                ],
                'author' => [
                    'en' => 'Marketing Team',
                    'ar' => 'فريق التسويق',
                ],
                'organizer_details' => [
                    'en' => 'Contact: info@digitalinnovation.kw | Website: www.digitalinnovation.kw | Phone: +965 2222 3333',
                    'ar' => 'للتواصل: info@digitalinnovation.kw | الموقع: www.digitalinnovation.kw | الهاتف: +965 2222 3333',
                ],
                'published_at' => Carbon::now(),
                'meta_title' => [
                    'en' => 'Digital Marketing Summit 2025 - Kuwait\'s Premier Marketing Event',
                    'ar' => 'قمة التسويق الرقمي 2025 - الحدث التسويقي الأول في الكويت',
                ],
                'meta_description' => [
                    'en' => 'Join industry leaders at Kuwait\'s premier digital marketing summit. Learn cutting-edge strategies, network with experts, and transform your marketing approach.',
                    'ar' => 'انضم إلى قادة الصناعة في قمة التسويق الرقمي الأولى في الكويت. تعلم الاستراتيجيات المتطورة وتواصل مع الخبراء وغير نهجك التسويقي.',
                ],
            ],
            [
                'title' => [
                    'en' => 'Startup Pitch Competition',
                    'ar' => 'مسابقة عرض الشركات الناشئة',
                ],
                'slug' => [
                    'en' => 'startup-pitch-competition',
                    'ar' => 'مسابقة-عرض-الشركات-الناشئة',
                ],
                'description' => [
                    'en' => 'Present your startup idea to investors and win funding opportunities.',
                    'ar' => 'اعرض فكرة شركتك الناشئة على المستثمرين واحصل على فرص التمويل.',
                ],
                'content' => [
                    'en' => '<h2>Pitch Your Startup</h2><p>An exciting opportunity for entrepreneurs to present their innovative ideas to a panel of experienced investors and industry experts.</p><h3>Prizes</h3><ul><li>1st Place: $50,000 funding</li><li>2nd Place: $25,000 funding</li><li>3rd Place: $10,000 funding</li><li>Mentorship opportunities for all participants</li></ul>',
                    'ar' => '<h2>اعرض شركتك الناشئة</h2><p>فرصة مثيرة لرواد الأعمال لعرض أفكارهم المبتكرة على لجنة من المستثمرين الخبراء وخبراء الصناعة.</p><h3>الجوائز</h3><ul><li>المركز الأول: تمويل 50,000 دولار</li><li>المركز الثاني: تمويل 25,000 دولار</li><li>المركز الثالث: تمويل 10,000 دولار</li><li>فرص إرشاد لجميع المشاركين</li></ul>',
                ],
                'start_date' => Carbon::now()->addDays(45)->setTime(18, 0),
                'end_date' => Carbon::now()->addDays(45)->setTime(21, 0),
                'timezone' => 'Asia/Kuwait',
                'status' => 'published',
                'priority' => 'urgent',
                'featured' => true,
                'location' => 'Innovation Center Kuwait',
                'location_details' => 'Conference Room B, Salmiya, Kuwait',
                'capacity' => 50,
                'registration_enabled' => true,
                'registration_starts_at' => Carbon::now(),
                'registration_ends_at' => Carbon::now()->addDays(40),
                'price' => 0.00,
                'organizer' => [
                    'en' => 'Kuwait Entrepreneurs Network',
                    'ar' => 'شبكة رواد الأعمال الكويتية',
                ],
                'author' => [
                    'en' => 'Startup Community',
                    'ar' => 'مجتمع الشركات الناشئة',
                ],
                'published_at' => Carbon::now(),
                'meta_title' => [
                    'en' => 'Startup Pitch Competition Kuwait - Win $50K Funding',
                    'ar' => 'مسابقة عرض الشركات الناشئة الكويت - اربح تمويل 50 ألف دولار',
                ],
                'meta_description' => [
                    'en' => 'Present your startup to investors at Kuwait\'s biggest pitch competition. Win up to $50,000 funding plus mentorship. Register now!',
                    'ar' => 'اعرض شركتك الناشئة على المستثمرين في أكبر مسابقة عرض في الكويت. اربح تمويل يصل إلى 50,000 دولار بالإضافة إلى الإرشاد. سجل الآن!',
                ],
            ],
            [
                'title' => [
                    'en' => 'AI and Machine Learning Workshop',
                    'ar' => 'ورشة الذكاء الاصطناعي والتعلم الآلي',
                ],
                'slug' => [
                    'en' => 'ai-machine-learning-workshop',
                    'ar' => 'ورشة-الذكاء-الاصطناعي-والتعلم-الآلي',
                ],
                'description' => [
                    'en' => 'Hands-on workshop covering the fundamentals of AI and machine learning.',
                    'ar' => 'ورشة عملية تغطي أساسيات الذكاء الاصطناعي والتعلم الآلي.',
                ],
                'content' => [
                    'en' => '<h2>Workshop Overview</h2><p>This intensive workshop will provide participants with practical knowledge of AI and machine learning concepts, tools, and applications.</p><h3>Topics Covered</h3><ul><li>Introduction to AI and ML</li><li>Popular frameworks and tools</li><li>Building your first ML model</li><li>Real-world applications</li></ul>',
                    'ar' => '<h2>نظرة عامة على الورشة</h2><p>ستوفر هذه الورشة المكثفة للمشاركين معرفة عملية بمفاهيم الذكاء الاصطناعي والتعلم الآلي والأدوات والتطبيقات.</p><h3>المواضيع المغطاة</h3><ul><li>مقدمة في الذكاء الاصطناعي والتعلم الآلي</li><li>الأطر والأدوات الشائعة</li><li>بناء نموذجك الأول للتعلم الآلي</li><li>التطبيقات الواقعية</li></ul>',
                ],
                'start_date' => Carbon::now()->addDays(15)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(16)->setTime(16, 0),
                'timezone' => 'Asia/Kuwait',
                'status' => 'published',
                'priority' => 'medium',
                'featured' => false,
                'location' => 'Kuwait University',
                'location_details' => 'Computer Science Building, Room 201',
                'capacity' => 30,
                'registration_enabled' => true,
                'registration_starts_at' => Carbon::now(),
                'registration_ends_at' => Carbon::now()->addDays(10),
                'price' => 150.00,
                'organizer' => [
                    'en' => 'Tech Education Kuwait',
                    'ar' => 'التعليم التقني الكويت',
                ],
                'author' => [
                    'en' => 'AI Research Team',
                    'ar' => 'فريق بحوث الذكاء الاصطناعي',
                ],
                'published_at' => Carbon::now(),
                'meta_title' => [
                    'en' => 'AI & Machine Learning Workshop Kuwait - Hands-on Training',
                    'ar' => 'ورشة الذكاء الاصطناعي والتعلم الآلي الكويت - تدريب عملي',
                ],
                'meta_description' => [
                    'en' => 'Master AI and machine learning in our intensive hands-on workshop. Learn from experts, build real projects, and advance your tech career in Kuwait.',
                    'ar' => 'أتقن الذكاء الاصطناعي والتعلم الآلي في ورشة العمل المكثفة والعملية. تعلم من الخبراء وابني مشاريع حقيقية وطور مسيرتك التقنية في الكويت.',
                ],
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }

        $this->command->info('Events seeded successfully!');
    }
}
