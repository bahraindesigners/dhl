<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 8 sample offers
        Offer::factory()->count(8)->create();

        // Create some specific offers with meaningful content
        Offer::create([
            'title' => [
                'en' => 'Summer Sale - Up to 50% Off',
                'ar' => 'تخفيضات الصيف - خصم يصل إلى 50%',
            ],
            'description' => [
                'en' => 'Don\'t miss our biggest summer sale with amazing discounts on all products.',
                'ar' => 'لا تفوت أكبر تخفيضات الصيف مع خصومات مذهلة على جميع المنتجات.',
            ],
            'company_name' => [
                'en' => 'Fashion World',
                'ar' => 'عالم الأزياء',
            ],
            'discount' => '50%',
            'offer_description' => [
                'en' => '<h3>Summer Sale Details</h3><p>Get ready for the hottest deals of the summer! We\'re offering up to 50% off on selected items from our premium collection.</p><ul><li>Valid until end of August</li><li>Cannot be combined with other offers</li><li>Free shipping on orders over $100</li></ul>',
                'ar' => '<h3>تفاصيل تخفيضات الصيف</h3><p>استعد لأهم العروض الصيفية! نقدم خصومات تصل إلى 50% على مجموعة مختارة من منتجاتنا المميزة.</p><ul><li>صالح حتى نهاية أغسطس</li><li>لا يمكن دمجه مع عروض أخرى</li><li>شحن مجاني للطلبات أكثر من 100 دولار</li></ul>',
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Offer::create([
            'title' => [
                'en' => 'Black Friday Special',
                'ar' => 'عرض الجمعة السوداء الخاص',
            ],
            'description' => [
                'en' => 'Exclusive Black Friday deals with unbeatable prices on electronics.',
                'ar' => 'عروض حصرية للجمعة السوداء بأسعار لا تقبل المنافسة على الإلكترونيات.',
            ],
            'company_name' => [
                'en' => 'Tech Paradise',
                'ar' => 'جنة التقنية',
            ],
            'discount' => '70%',
            'offer_description' => [
                'en' => '<h3>Black Friday Electronics Sale</h3><p>The biggest tech sale of the year is here! Save up to 70% on laptops, smartphones, and accessories.</p><h4>Featured Deals:</h4><ul><li>Laptops from $299</li><li>Smartphones from $199</li><li>Wireless headphones from $49</li></ul><p><strong>Limited time offer - Shop now!</strong></p>',
                'ar' => '<h3>تخفيضات الجمعة السوداء للإلكترونيات</h3><p>أكبر تخفيضات التقنية في السنة هنا! وفر حتى 70% على أجهزة الكمبيوتر المحمولة والهواتف الذكية والإكسسوارات.</p><h4>العروض المميزة:</h4><ul><li>أجهزة كمبيوتر محمولة من 299 دولار</li><li>هواتف ذكية من 199 دولار</li><li>سماعات لاسلكية من 49 دولار</li></ul><p><strong>عرض لفترة محدودة - تسوق الآن!</strong></p>',
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);
    }
}
