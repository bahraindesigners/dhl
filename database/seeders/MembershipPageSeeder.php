<?php

namespace Database\Seeders;

use App\Models\MembershipPage;
use Illuminate\Database\Seeder;

class MembershipPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MembershipPage::create([
            'how_to_join' => [
                'en' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 2],
                            'content' => [
                                ['type' => 'text', 'text' => 'Joining Our Union'],
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'content' => [
                                ['type' => 'text', 'text' => 'Welcome to the DHL Workers Union! We are committed to protecting the rights and interests of all DHL employees across the region.'],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'Eligibility Requirements'],
                            ],
                        ],
                        [
                            'type' => 'bulletList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Must be a current DHL employee'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Completed probationary period (minimum 3 months)'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Agree to union principles and code of conduct'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'Application Process'],
                            ],
                        ],
                        [
                            'type' => 'orderedList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Complete the membership application form below'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Submit required documentation (employee ID, proof of employment)'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Attend orientation session (scheduled after application review)'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Pay initial membership dues'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'ar' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 2],
                            'content' => [
                                ['type' => 'text', 'text' => 'الانضمام إلى نقابتنا'],
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'content' => [
                                ['type' => 'text', 'text' => 'مرحباً بكم في نقابة عمال DHL! نحن ملتزمون بحماية حقوق ومصالح جميع موظفي DHL في المنطقة.'],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'متطلبات الأهلية'],
                            ],
                        ],
                        [
                            'type' => 'bulletList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'يجب أن تكون موظفاً حالياً في DHL'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'إكمال فترة التجربة (3 أشهر كحد أدنى)'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'الموافقة على مبادئ النقابة وقواعد السلوك'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'عملية التقديم'],
                            ],
                        ],
                        [
                            'type' => 'orderedList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'إكمال نموذج طلب العضوية أدناه'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'تقديم الوثائق المطلوبة (هوية الموظف، إثبات العمل)'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'حضور جلسة التوجيه (يتم جدولتها بعد مراجعة الطلب)'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'دفع رسوم العضوية الأولية'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'union_benefits' => [
                'en' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 2],
                            'content' => [
                                ['type' => 'text', 'text' => 'Member Benefits'],
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'content' => [
                                ['type' => 'text', 'text' => 'As a union member, you gain access to comprehensive benefits designed to protect and support you throughout your career.'],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'Legal Protection'],
                            ],
                        ],
                        [
                            'type' => 'bulletList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Free legal representation in workplace disputes'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Employment contract review and advice'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Grievance procedure support'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'Financial Benefits'],
                            ],
                        ],
                        [
                            'type' => 'bulletList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Collective bargaining for better wages and benefits'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Emergency financial assistance fund'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Retirement planning support'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'Professional Development'],
                            ],
                        ],
                        [
                            'type' => 'bulletList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Access to training and skills development programs'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Career advancement opportunities'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'Networking events and conferences'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'ar' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 2],
                            'content' => [
                                ['type' => 'text', 'text' => 'مزايا الأعضاء'],
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'content' => [
                                ['type' => 'text', 'text' => 'كعضو في النقابة، تحصل على إمكانية الوصول إلى مزايا شاملة مصممة لحمايتك ودعمك طوال مسيرتك المهنية.'],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'الحماية القانونية'],
                            ],
                        ],
                        [
                            'type' => 'bulletList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'تمثيل قانوني مجاني في نزاعات مكان العمل'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'مراجعة عقد العمل والمشورة'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'دعم إجراءات التظلم'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'المزايا المالية'],
                            ],
                        ],
                        [
                            'type' => 'bulletList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'التفاوض الجماعي للحصول على أجور ومزايا أفضل'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'صندوق المساعدة المالية الطارئة'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'دعم التخطيط للتقاعد'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'attrs' => ['level' => 3],
                            'content' => [
                                ['type' => 'text', 'text' => 'التطوير المهني'],
                            ],
                        ],
                        [
                            'type' => 'bulletList',
                            'content' => [
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'الوصول إلى برامج التدريب وتطوير المهارات'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'فرص التقدم الوظيفي'],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => 'listItem',
                                    'content' => [
                                        [
                                            'type' => 'paragraph',
                                            'content' => [
                                                ['type' => 'text', 'text' => 'فعاليات التواصل والمؤتمرات'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'enable_member_form' => true,
        ]);
    }
}
