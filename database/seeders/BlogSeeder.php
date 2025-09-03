<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = BlogCategory::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No blog categories found. Please run BlogCategorySeeder first.');
            return;
        }

        $blogs = [
            [
                'title' => [
                    'en' => 'The Future of Artificial Intelligence',
                    'ar' => 'مستقبل الذكاء الاصطناعي'
                ],
                'slug' => [
                    'en' => 'future-of-artificial-intelligence',
                    'ar' => 'مستقبل-الذكاء-الاصطناعي'
                ],
                'excerpt' => [
                    'en' => 'Exploring how AI will transform our daily lives and industries.',
                    'ar' => 'استكشاف كيف سيحول الذكاء الاصطناعي حياتنا اليومية والصناعات.'
                ],
                'content' => [
                    'en' => '<p>Artificial Intelligence is rapidly evolving and transforming various aspects of our lives. From healthcare to transportation, AI is revolutionizing how we work, communicate, and solve complex problems.</p><p>In this comprehensive guide, we will explore the current state of AI technology and discuss its potential future applications. We will also examine the challenges and opportunities that lie ahead in this exciting field.</p>',
                    'ar' => '<p>يتطور الذكاء الاصطناعي بسرعة ويحول جوانب مختلفة من حياتنا. من الرعاية الصحية إلى النقل، يحدث الذكاء الاصطناعي ثورة في طريقة عملنا وتواصلنا وحل المشاكل المعقدة.</p><p>في هذا الدليل الشامل، سنستكشف الحالة الحالية لتكنولوجيا الذكاء الاصطناعي ونناقش تطبيقاتها المستقبلية المحتملة. سنفحص أيضًا التحديات والفرص التي تنتظرنا في هذا المجال المثير.</p>'
                ],
                'meta_title' => [
                    'en' => 'AI Future: Transforming Industries and Daily Life',
                    'ar' => 'مستقبل الذكاء الاصطناعي: تحويل الصناعات والحياة اليومية'
                ],
                'meta_description' => [
                    'en' => 'Discover how artificial intelligence is shaping the future across industries and transforming our daily experiences.',
                    'ar' => 'اكتشف كيف يشكل الذكاء الاصطناعي المستقبل عبر الصناعات ويحول تجاربنا اليومية.'
                ],
                'author' => 'Tech Editor',
                'status' => 'published',
                'featured' => true,
                'published_at' => now()->subDays(1),
                'views_count' => 150,
                'reading_time' => 5,
                'blog_category_id' => $categories->where('name->en', 'Technology')->first()?->id,
            ],
            [
                'title' => [
                    'en' => 'Building Successful Startups in 2025',
                    'ar' => 'بناء شركات ناشئة ناجحة في 2025'
                ],
                'slug' => [
                    'en' => 'building-successful-startups-2025',
                    'ar' => 'بناء-شركات-ناشئة-ناجحة-2025'
                ],
                'excerpt' => [
                    'en' => 'Essential strategies and insights for launching a successful startup in today\'s competitive market.',
                    'ar' => 'الاستراتيجيات والرؤى الأساسية لإطلاق شركة ناشئة ناجحة في السوق التنافسي اليوم.'
                ],
                'content' => [
                    'en' => '<p>Starting a business in 2025 requires a deep understanding of modern market dynamics, customer needs, and technological trends. This article provides a comprehensive roadmap for aspiring entrepreneurs.</p><p>We will cover key topics including market research, product development, funding strategies, and scaling your business for long-term success.</p>',
                    'ar' => '<p>إن بدء عمل تجاري في عام 2025 يتطلب فهمًا عميقًا لديناميكيات السوق الحديثة واحتياجات العملاء والاتجاهات التكنولوجية. توفر هذه المقالة خارطة طريق شاملة لرجال الأعمال الطموحين.</p><p>سنغطي الموضوعات الرئيسية بما في ذلك أبحاث السوق وتطوير المنتجات واستراتيجيات التمويل وتوسيع نطاق عملك لتحقيق النجاح طويل المدى.</p>'
                ],
                'author' => 'Business Analyst',
                'status' => 'published',
                'featured' => false,
                'published_at' => now()->subDays(3),
                'views_count' => 89,
                'reading_time' => 7,
                'blog_category_id' => $categories->where('name->en', 'Business')->first()?->id,
            ],
            [
                'title' => [
                    'en' => '10 Healthy Habits for a Better Life',
                    'ar' => '10 عادات صحية لحياة أفضل'
                ],
                'slug' => [
                    'en' => '10-healthy-habits-better-life',
                    'ar' => '10-عادات-صحية-حياة-أفضل'
                ],
                'excerpt' => [
                    'en' => 'Simple yet effective daily habits that can transform your health and well-being.',
                    'ar' => 'عادات يومية بسيطة ولكنها فعالة يمكن أن تحول صحتك ورفاهيتك.'
                ],
                'content' => [
                    'en' => '<p>Maintaining good health is not about dramatic changes or extreme measures. It\'s about developing consistent, sustainable habits that support your physical and mental well-being.</p><p>In this article, we will explore ten evidence-based habits that you can easily incorporate into your daily routine for lasting health benefits.</p>',
                    'ar' => '<p>الحفاظ على صحة جيدة لا يتعلق بالتغييرات الدراماتيكية أو الإجراءات المتطرفة. يتعلق الأمر بتطوير عادات متسقة ومستدامة تدعم رفاهيتك الجسدية والعقلية.</p><p>في هذه المقالة، سنستكشف عشر عادات قائمة على الأدلة يمكنك دمجها بسهولة في روتينك اليومي للحصول على فوائد صحية دائمة.</p>'
                ],
                'author' => 'Health Expert',
                'status' => 'published',
                'featured' => true,
                'published_at' => now()->subDays(5),
                'views_count' => 234,
                'reading_time' => 4,
                'blog_category_id' => $categories->where('name->en', 'Health')->first()?->id,
            ],
        ];

        foreach ($blogs as $blogData) {
            $blog = Blog::create($blogData);
            
            // You can add media files here if needed
            // $blog->addMediaFromUrl('path/to/image.jpg')->toMediaCollection('featured_image');
        }

        $this->command->info('Blog posts seeded successfully!');
    }
}
