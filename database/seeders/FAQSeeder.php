<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // General FAQs
            [
                'question' => [
                    'en' => 'What is DHL Events Platform?',
                    'ar' => 'ما هي منصة فعاليات DHL؟',
                ],
                'answer' => [
                    'en' => 'DHL Events Platform is a comprehensive event management system that allows you to discover, register for, and manage events in Kuwait. Our platform offers seamless registration, multilingual support, and integrated payment processing.',
                    'ar' => 'منصة فعاليات DHL هي نظام إدارة فعاليات شامل يتيح لك اكتشاف والتسجيل في وإدارة الفعاليات في الكويت. توفر منصتنا تسجيلاً سلساً ودعماً متعدد اللغات ومعالجة مدفوعات متكاملة.',
                ],
                'category' => 'general',
                'sort_order' => 1,
                'is_featured' => true,
                'status' => 'active',
                'slug' => 'what-is-dhl-events-platform',
                'published_at' => now(),
                'meta_title' => [
                    'en' => 'What is DHL Events Platform? - FAQ',
                    'ar' => 'ما هي منصة فعاليات DHL؟ - الأسئلة الشائعة',
                ],
                'meta_description' => [
                    'en' => 'Learn about DHL Events Platform, a comprehensive event management system for Kuwait with multilingual support and integrated payments.',
                    'ar' => 'تعرف على منصة فعاليات DHL، نظام إدارة الفعاليات الشامل للكويت مع الدعم متعدد اللغات والمدفوعات المتكاملة.',
                ],
            ],

            // Events FAQs
            [
                'question' => [
                    'en' => 'How do I find events near me?',
                    'ar' => 'كيف أجد الفعاليات القريبة مني؟',
                ],
                'answer' => [
                    'en' => 'You can browse events by location, category, or date using our search filters. All events display location details and you can filter by proximity to find events in your area.',
                    'ar' => 'يمكنك تصفح الفعاليات حسب الموقع أو الفئة أو التاريخ باستخدام مرشحات البحث. تعرض جميع الفعاليات تفاصيل الموقع ويمكنك التصفية حسب القرب للعثور على الفعاليات في منطقتك.',
                ],
                'category' => 'events',
                'sort_order' => 1,
                'is_featured' => true,
                'status' => 'active',
                'slug' => 'how-to-find-events-near-me',
                'published_at' => now(),
                'meta_title' => [
                    'en' => 'How to Find Events Near Me - DHL Events FAQ',
                    'ar' => 'كيفية العثور على الفعاليات القريبة مني - أسئلة شائعة',
                ],
                'meta_description' => [
                    'en' => 'Learn how to find and filter events by location, category, and date to discover events near you.',
                    'ar' => 'تعلم كيفية العثور على الفعاليات وتصفيتها حسب الموقع والفئة والتاريخ لاكتشاف الفعاليات القريبة منك.',
                ],
            ],

            // Registration FAQs
            [
                'question' => [
                    'en' => 'How do I register for an event?',
                    'ar' => 'كيف أسجل في فعالية؟',
                ],
                'answer' => [
                    'en' => 'To register for an event, click on the event you\'re interested in, review the details, and click "Register Now". Fill in your information, choose your payment method, and complete the registration process. You\'ll receive a confirmation email with your registration details.',
                    'ar' => 'للتسجيل في فعالية، انقر على الفعالية التي تهمك، راجع التفاصيل، وانقر على "سجل الآن". املأ معلوماتك، اختر طريقة الدفع، وأكمل عملية التسجيل. ستتلقى بريداً إلكترونياً للتأكيد مع تفاصيل تسجيلك.',
                ],
                'category' => 'registration',
                'sort_order' => 1,
                'is_featured' => true,
                'status' => 'active',
                'slug' => 'how-to-register-for-event',
                'published_at' => now(),
                'meta_title' => [
                    'en' => 'How to Register for Events - Step by Step Guide',
                    'ar' => 'كيفية التسجيل في الفعاليات - دليل خطوة بخطوة',
                ],
                'meta_description' => [
                    'en' => 'Step-by-step guide on how to register for events, complete payment, and receive confirmation.',
                    'ar' => 'دليل خطوة بخطوة حول كيفية التسجيل في الفعاليات وإكمال الدفع وتلقي التأكيد.',
                ],
            ],

            // Payment FAQs
            [
                'question' => [
                    'en' => 'What payment methods do you accept?',
                    'ar' => 'ما هي طرق الدفع التي تقبلونها؟',
                ],
                'answer' => [
                    'en' => 'We accept various payment methods including credit cards (Visa, MasterCard), K-Net, PayPal, bank transfers, and cash payments. The available payment methods may vary depending on the event organizer.',
                    'ar' => 'نقبل طرق دفع مختلفة بما في ذلك بطاقات الائتمان (فيزا، ماستركارد)، كي-نت، باي بال، التحويلات البنكية، والدفع النقدي. قد تختلف طرق الدفع المتاحة حسب منظم الفعالية.',
                ],
                'category' => 'payment',
                'sort_order' => 1,
                'is_featured' => false,
                'status' => 'active',
                'slug' => 'accepted-payment-methods',
                'published_at' => now(),
                'meta_title' => [
                    'en' => 'Accepted Payment Methods - DHL Events',
                    'ar' => 'طرق الدفع المقبولة - فعاليات DHL',
                ],
                'meta_description' => [
                    'en' => 'Learn about all accepted payment methods including credit cards, K-Net, PayPal, and bank transfers.',
                    'ar' => 'تعرف على جميع طرق الدفع المقبولة بما في ذلك بطاقات الائتمان وكي-نت وباي بال والتحويلات البنكية.',
                ],
            ],

            // Technical Support FAQs
            [
                'question' => [
                    'en' => 'I\'m having trouble with my registration. What should I do?',
                    'ar' => 'أواجه مشكلة في تسجيلي. ماذا يجب أن أفعل؟',
                ],
                'answer' => [
                    'en' => 'If you\'re experiencing technical issues with your registration, please try clearing your browser cache and cookies first. If the problem persists, contact our support team at support@dhl.test or call +965 2222 3333. Include your email address and a description of the issue.',
                    'ar' => 'إذا كنت تواجه مشاكل تقنية في تسجيلك، يرجى محاولة مسح ذاكرة التخزين المؤقت وملفات تعريف الارتباط في متصفحك أولاً. إذا استمرت المشكلة، اتصل بفريق الدعم على support@dhl.test أو اتصل على +965 2222 3333. أرفق عنوان بريدك الإلكتروني ووصفاً للمشكلة.',
                ],
                'category' => 'technical',
                'sort_order' => 1,
                'is_featured' => false,
                'status' => 'active',
                'slug' => 'registration-technical-issues',
                'published_at' => now(),
                'meta_title' => [
                    'en' => 'Registration Technical Issues - Help & Support',
                    'ar' => 'مشاكل تقنية في التسجيل - المساعدة والدعم',
                ],
                'meta_description' => [
                    'en' => 'Get help with registration technical issues, troubleshooting steps, and contact information for support.',
                    'ar' => 'احصل على مساعدة في المشاكل التقنية للتسجيل وخطوات استكشاف الأخطاء ومعلومات الاتصال للدعم.',
                ],
            ],

            // Account FAQs
            [
                'question' => [
                    'en' => 'Do I need to create an account to register for events?',
                    'ar' => 'هل أحتاج إلى إنشاء حساب للتسجيل في الفعاليات؟',
                ],
                'answer' => [
                    'en' => 'While you can register for events as a guest, creating an account offers many benefits including faster checkout, order history, saved payment methods, and personalized event recommendations. Account creation is free and takes just a minute.',
                    'ar' => 'بينما يمكنك التسجيل في الفعاليات كضيف، إنشاء حساب يوفر فوائد عديدة بما في ذلك الدفع السريع وتاريخ الطلبات وطرق الدفع المحفوظة والتوصيات الشخصية للفعاليات. إنشاء الحساب مجاني ويستغرق دقيقة واحدة فقط.',
                ],
                'category' => 'account',
                'sort_order' => 1,
                'is_featured' => false,
                'status' => 'active',
                'slug' => 'do-i-need-account-to-register',
                'published_at' => now(),
                'meta_title' => [
                    'en' => 'Do I Need an Account to Register? - DHL Events',
                    'ar' => 'هل أحتاج حساب للتسجيل؟ - فعاليات DHL',
                ],
                'meta_description' => [
                    'en' => 'Learn about the benefits of creating an account vs guest registration for events.',
                    'ar' => 'تعرف على فوائد إنشاء حساب مقابل التسجيل كضيف في الفعاليات.',
                ],
            ],
        ];

        foreach ($faqs as $faqData) {
            FAQ::create($faqData);
        }

        // Create additional random FAQs
        FAQ::factory()->count(15)->create();

        $this->command->info('FAQ data seeded successfully!');
    }
}
