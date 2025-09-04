<?php

namespace Database\Seeders;

use App\Models\Download;
use Illuminate\Database\Seeder;

class DownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific downloads for each category
        $downloads = [
            [
                'title' => [
                    'en' => 'Employee Handbook 2025',
                    'ar' => 'دليل الموظف 2025',
                ],
                'description' => [
                    'en' => 'Complete guide covering company policies, procedures, benefits, and expectations for all employees.',
                    'ar' => 'دليل شامل يغطي سياسات الشركة والإجراءات والمزايا والتوقعات لجميع الموظفين.',
                ],
                'category' => 'handbooks',
                'access_level' => 'employees',
                'is_active' => true,
                'sort_order' => 1,
                'download_count' => 245,
                'file_size' => 2500000,
                'file_type' => 'application/pdf',
            ],
            [
                'title' => [
                    'en' => 'Leave Request Form',
                    'ar' => 'نموذج طلب الإجازة',
                ],
                'description' => [
                    'en' => 'Official form for submitting vacation, sick leave, and other time-off requests.',
                    'ar' => 'النموذج الرسمي لتقديم طلبات الإجازة والإجازة المرضية وطلبات الإجازة الأخرى.',
                ],
                'category' => 'forms',
                'access_level' => 'employees',
                'is_active' => true,
                'sort_order' => 2,
                'download_count' => 189,
                'file_size' => 125000,
                'file_type' => 'application/pdf',
            ],
            [
                'title' => [
                    'en' => 'IT Security Policy',
                    'ar' => 'سياسة أمن تكنولوجيا المعلومات',
                ],
                'description' => [
                    'en' => 'Guidelines for maintaining information security, password policies, and data protection.',
                    'ar' => 'إرشادات للحفاظ على أمن المعلومات وسياسات كلمة المرور وحماية البيانات.',
                ],
                'category' => 'policies',
                'access_level' => 'employees',
                'is_active' => true,
                'sort_order' => 3,
                'download_count' => 156,
                'file_size' => 890000,
                'file_type' => 'application/pdf',
            ],
            [
                'title' => [
                    'en' => 'New Employee Onboarding Checklist',
                    'ar' => 'قائمة مراجعة تأهيل الموظف الجديد',
                ],
                'description' => [
                    'en' => 'Step-by-step checklist for new hires to complete during their first week.',
                    'ar' => 'قائمة مراجعة خطوة بخطوة للموظفين الجدد لإكمالها خلال أسبوعهم الأول.',
                ],
                'category' => 'training',
                'access_level' => 'managers',
                'is_active' => true,
                'sort_order' => 4,
                'download_count' => 78,
                'file_size' => 345000,
                'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
            [
                'title' => [
                    'en' => 'Company Organizational Chart',
                    'ar' => 'الهيكل التنظيمي للشركة',
                ],
                'description' => [
                    'en' => 'Current organizational structure showing departments, teams, and reporting lines.',
                    'ar' => 'الهيكل التنظيمي الحالي يوضح الأقسام والفرق وخطوط التقارير.',
                ],
                'category' => 'guides',
                'access_level' => 'public',
                'is_active' => true,
                'sort_order' => 5,
                'download_count' => 312,
                'file_size' => 1200000,
                'file_type' => 'image/png',
            ],
            [
                'title' => [
                    'en' => 'Annual Performance Report 2024',
                    'ar' => 'تقرير الأداء السنوي 2024',
                ],
                'description' => [
                    'en' => 'Comprehensive analysis of company performance, achievements, and future goals.',
                    'ar' => 'تحليل شامل لأداء الشركة والإنجازات والأهداف المستقبلية.',
                ],
                'category' => 'reports',
                'access_level' => 'managers',
                'is_active' => true,
                'sort_order' => 6,
                'download_count' => 89,
                'file_size' => 4500000,
                'file_type' => 'application/pdf',
            ],
            [
                'title' => [
                    'en' => 'Expense Report Template',
                    'ar' => 'قالب تقرير المصاريف',
                ],
                'description' => [
                    'en' => 'Excel template for submitting monthly expense reports and reimbursements.',
                    'ar' => 'قالب Excel لتقديم تقارير المصاريف الشهرية والاسترداد.',
                ],
                'category' => 'templates',
                'access_level' => 'employees',
                'is_active' => true,
                'sort_order' => 7,
                'download_count' => 134,
                'file_size' => 87000,
                'file_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ],
            [
                'title' => [
                    'en' => 'Emergency Contact Information',
                    'ar' => 'معلومات الاتصال في حالات الطوارئ',
                ],
                'description' => [
                    'en' => 'Important contact numbers for emergencies, security, and after-hours support.',
                    'ar' => 'أرقام الاتصال المهمة للطوارئ والأمن والدعم خارج ساعات العمل.',
                ],
                'category' => 'other',
                'access_level' => 'employees',
                'is_active' => true,
                'sort_order' => 8,
                'download_count' => 267,
                'file_size' => 45000,
                'file_type' => 'text/plain',
            ],
        ];

        foreach ($downloads as $downloadData) {
            Download::create($downloadData);
        }

        // Create additional random downloads
        Download::factory(15)->create();
    }
}
