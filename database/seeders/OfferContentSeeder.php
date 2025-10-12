<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class OfferContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offers = [
            [
                'title' => [
                    'en' => 'Clear Vision Optical - Exclusive Discounts',
                    'ar' => 'نظارات الرؤية الواضحة - خصومات حصرية',
                ],
                'description' => [
                    'en' => 'Special offers on branded frames, sunglasses, and prescription lenses for DHL union members.',
                    'ar' => 'عروض خاصة على الإطارات ذات العلامات التجارية والنظارات الشمسية والعدسات الطبية لأعضاء نقابة DHL.',
                ],
                'company_name' => [
                    'en' => 'Clear Vision Optical',
                    'ar' => 'نظارات الرؤية الواضحة',
                ],
                'discount' => 'Up to 50%',
                'offer_description' => [
                    'en' => '<h3>🟢 Exclusive Offers</h3>
<ul>
<li><strong>35% Discount</strong> on branded frames and sunglasses</li>
<li><strong>50% Discount</strong> on Clear Vision\'s own-brand frames and sunglasses</li>
<li><strong>30% Discount</strong> on all prescription lenses</li>
<li><strong>One free eye examination</strong> per year</li>
<li><strong>A free trial pair</strong> of clear contact lenses</li>
</ul>

<h3>📞 Contact Information</h3>
<p><strong>Phone:</strong> 33950201</p>
<p><strong>Location:</strong> Manama, Bahrain</p>
<p><strong>Website:</strong> <a href="https://clearvisionme.com" target="_blank">clearvisionme.com</a></p>
<p><strong>Instagram:</strong> <a href="https://www.instagram.com/clearvisionoptics" target="_blank">@clearvisionoptics</a></p>',
                    'ar' => '<h3>🟢 العروض الحصرية</h3>
<ul>
<li><strong>خصم 35%</strong> على الإطارات والنظارات الشمسية من العلامات التجارية العالمية</li>
<li><strong>خصم 50%</strong> على الإطارات والنظارات الشمسية من العلامة التجارية الخاصة بـClear Vision</li>
<li><strong>خصم 30%</strong> على جميع العدسات الطبية</li>
<li><strong>فحص نظر مجاني</strong> مرة واحدة سنويًا</li>
<li><strong>تجربة مجانية</strong> لزوج واحد من العدسات اللاصقة الشفافة</li>
</ul>

<h3>📞 معلومات الاتصال</h3>
<p><strong>الهاتف:</strong> 33950201</p>
<p><strong>العنوان:</strong> المنامة، البحرين</p>
<p><strong>الموقع الإلكتروني:</strong> <a href="https://clearvisionme.com" target="_blank">clearvisionme.com</a></p>
<p><strong>إنستغرام:</strong> <a href="https://www.instagram.com/clearvisionoptics" target="_blank">@clearvisionoptics</a></p>',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => [
                    'en' => 'Alkuwaiti Auto Service - Car Maintenance Discounts',
                    'ar' => 'الكويتي لخدمات السيارات - خصومات الصيانة',
                ],
                'description' => [
                    'en' => 'Exclusive car maintenance offers including discounts on tires, batteries, car wash, and 0% installment plans.',
                    'ar' => 'عروض صيانة السيارات الحصرية بما في ذلك خصومات على الإطارات والبطاريات وغسيل السيارات وخطط التقسيط بدون فوائد.',
                ],
                'company_name' => [
                    'en' => 'Alkuwaiti Auto Service',
                    'ar' => 'الكويتي لخدمات السيارات',
                ],
                'discount' => 'Up to 25%',
                'offer_description' => [
                    'en' => '<h3>🔧 Offer Details</h3>
<ul>
<li><strong>25% Discount</strong> on all tires – Get brand-new tires for your car at unbeatable prices</li>
<li><strong>20% Discount</strong> on batteries – Replace your car battery at a discounted price for a worry-free drive</li>
<li><strong>20% Discount</strong> on car wash services – Keep your car looking spotless with professional cleaning</li>
<li><strong>10% Discount</strong> on all other services – Including general maintenance, mechanical repairs, and more</li>
<li><strong>Free oil filter change</strong> with every oil change (valid only for Castrol Magnatec & Edge oils)</li>
<li><strong>0% interest installment plans</strong> for tires – Get new tires now and pay in easy installments without extra charges</li>
</ul>

<h3>📍 Available Branches</h3>
<p>Adliya | Riffa | Seef | Sitra | Tubli | Awali | Hoora | Mameer | Salmabad | Central Market | Busaiteen | Isa Town | Hamad Town</p>

<h3>📞 Contact Information</h3>
<p><strong>Phone:</strong> 80408888</p>
<p><strong>Instagram:</strong> <a href="https://www.instagram.com/alkuwaiti_auto_service" target="_blank">@alkuwaiti_auto_service</a></p>',
                    'ar' => '<h3>🔧 تفاصيل العرض</h3>
<ul>
<li><strong>خصم 25%</strong> على جميع الإطارات – احصل على إطارات جديدة لسيارتك بأسعار تنافسية</li>
<li><strong>خصم 20%</strong> على البطاريات – استبدل بطارية سيارتك بسعر مخفض لضمان قيادة آمنة</li>
<li><strong>خصم 20%</strong> على غسيل السيارات – حافظ على نظافة ولمعان سيارتك مع خدمة الغسيل الاحترافية</li>
<li><strong>خصم 10%</strong> على جميع الخدمات الأخرى – تشمل الصيانة العامة، إصلاحات الميكانيكا، وغيرها</li>
<li><strong>تغيير فلتر الزيت مجانًا</strong> مع كل تغيير زيت (يسري فقط على زيوت Castrol Magnatec وEdge)</li>
<li><strong>إمكانية تقسيط الإطارات بدون فوائد</strong> – احصل على إطارات جديدة وادفع بأقساط مريحة بدون فوائد</li>
</ul>

<h3>📍 الفروع المتاحة</h3>
<p>العدلية | الرفاع | السيف | سترة | توبلي | العوالي | الحورة | المعامير | سلماباد | السوق المركزي | البسيتين | مدينة عيسى | مدينة حمد</p>

<h3>📞 معلومات الاتصال</h3>
<p><strong>الهاتف:</strong> 80408888</p>
<p><strong>إنستغرام:</strong> <a href="https://www.instagram.com/alkuwaiti_auto_service" target="_blank">@alkuwaiti_auto_service</a></p>',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => [
                    'en' => 'Salam Gas - 0% Interest Installment Plans',
                    'ar' => 'غاز السلام - تقسيط بدون فوائد',
                ],
                'description' => [
                    'en' => 'Exclusive 0% interest installment plans on all gas and equipment purchases for DHL union members.',
                    'ar' => 'خطط تقسيط حصرية بدون فوائد على جميع مشتريات الغاز والمعدات لأعضاء نقابة DHL.',
                ],
                'company_name' => [
                    'en' => 'Salam Gas',
                    'ar' => 'غاز السلام',
                ],
                'discount' => '0% Interest',
                'offer_description' => [
                    'en' => '<h3>🔥 Exclusive Benefits</h3>
<ul>
<li><strong>0% Interest Installment Plans</strong> – Buy now and pay in hassle-free installments</li>
<li><strong>Fast Service & Comprehensive Support</strong> – Get all your gas and equipment needs covered</li>
<li><strong>Exclusive offer</strong> available only for DHL Bahraini Trade Union workers</li>
</ul>

<h3>📞 Contact Information</h3>
<p><strong>Sales & Services:</strong> 17401212</p>
<p><strong>Maintenance:</strong> 13306660</p>
<p><strong>WhatsApp:</strong> 36077411</p>
<p><strong>Instagram:</strong> <a href="https://www.instagram.com/alsalambah" target="_blank">@alsalambah</a></p>

<p>🚀 Don\'t miss out! Take advantage of flexible installment plans, exclusively for DHL Bahraini Trade Union workers!</p>',
                    'ar' => '<h3>🔥 المزايا الحصرية</h3>
<ul>
<li><strong>تقسيط مرن بدون فوائد</strong> – اشترِ الآن وادفع بأقساط مريحة</li>
<li><strong>خدمة سريعة ودعم متكامل</strong> – حلول متكاملة لجميع احتياجات الغاز والمعدات</li>
<li><strong>العرض متاح فقط</strong> لعمال نقابة DHL البحرينية</li>
</ul>

<h3>📞 معلومات الاتصال</h3>
<p><strong>المبيعات والخدمات:</strong> 17401212</p>
<p><strong>الصيانة:</strong> 13306660</p>
<p><strong>واتساب:</strong> 36077411</p>
<p><strong>إنستغرام:</strong> <a href="https://www.instagram.com/alsalambah" target="_blank">@alsalambah</a></p>

<p>🚀 لا تفوّتوا الفرصة! استمتعوا بعروض التقسيط المرنة حصريًا لعمال نقابة DHL البحرينية!</p>',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => [
                    'en' => 'Zenet Electronics - 0% Interest on Electronics',
                    'ar' => 'زينت للإلكترونيات - تقسيط بدون فوائد',
                ],
                'description' => [
                    'en' => 'Buy electronics, home appliances, and air conditioning with 0% interest installment plans.',
                    'ar' => 'اشترِ الإلكترونيات والأجهزة المنزلية والتكييف بخطط تقسيط بدون فوائد.',
                ],
                'company_name' => [
                    'en' => 'Zenet Electronics',
                    'ar' => 'زينت للإلكترونيات',
                ],
                'discount' => '0% Interest',
                'offer_description' => [
                    'en' => '<h3>💡 Offer Details</h3>
<ul>
<li><strong>0% Interest Installment Plans</strong> – Buy now and pay in hassle-free installments</li>
<li><strong>Wide Range of Products</strong> – Including electronics, home appliances, air conditioning, and more</li>
<li><strong>Exclusive offer</strong> available only for DHL Bahraini Trade Union workers</li>
</ul>

<h3>📞 Contact Information</h3>
<p><strong>Sales & Services:</strong> 17224220</p>
<p><strong>Dragon Mall Showroom:</strong> 17702103</p>
<p><strong>WhatsApp:</strong> 39640405</p>
<p><strong>Website:</strong> <a href="https://zenet.net" target="_blank">zenet.net</a></p>
<p><strong>Instagram:</strong> <a href="https://www.instagram.com/zenetelectronics" target="_blank">@zenetelectronics</a></p>

<p>🚀 Don\'t miss out! Take advantage of flexible installment plans, exclusively for DHL Bahraini Trade Union workers!</p>',
                    'ar' => '<h3>💡 تفاصيل العرض</h3>
<ul>
<li><strong>تقسيط مرن بدون فوائد</strong> – اشترِ الآن وادفع بأقساط مريحة</li>
<li><strong>منتجات متنوعة</strong> – تشمل الإلكترونيات، الأجهزة المنزلية، التكييف، وغيرها</li>
<li><strong>العرض متاح فقط</strong> لعمال نقابة DHL البحرينية</li>
</ul>

<h3>📞 معلومات الاتصال</h3>
<p><strong>المبيعات والخدمات:</strong> 17224220</p>
<p><strong>معرض دراغون مول:</strong> 17702103</p>
<p><strong>واتساب:</strong> 39640405</p>
<p><strong>الموقع الإلكتروني:</strong> <a href="https://zenet.net" target="_blank">zenet.net</a></p>
<p><strong>إنستغرام:</strong> <a href="https://www.instagram.com/zenetelectronics" target="_blank">@zenetelectronics</a></p>

<p>🚀 لا تفوّتوا الفرصة! استمتعوا بعروض التقسيط المرنة حصريًا لعمال نقابة DHL البحرينية!</p>',
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => [
                    'en' => 'Travel Now, Pay Later - Flight & Hotel Packages',
                    'ar' => 'سافر الآن وادفع لاحقًا - باقات الطيران والفنادق',
                ],
                'description' => [
                    'en' => 'Book flights, hotels, and travel packages with flexible 0% interest installment plans.',
                    'ar' => 'احجز تذاكر الطيران والفنادق وباقات السفر بخطط تقسيط مرنة بدون فوائد.',
                ],
                'company_name' => [
                    'en' => 'DHL Travel Services',
                    'ar' => 'خدمات السفر DHL',
                ],
                'discount' => '0% Interest',
                'offer_description' => [
                    'en' => '<h3>✈️ Travel Benefits</h3>
<ul>
<li><strong>Book your air tickets, hotels, and travel packages today</strong></li>
<li><strong>0% interest installment plan</strong> – Travel now and pay in easy installments</li>
<li><strong>Exclusive offer</strong> for DHL Bahraini Trade Union workers</li>
</ul>

<p>🚀 Don\'t miss this opportunity! Travel, enjoy, and pay later with no interest!</p>

<h3>Enjoy your trip with flexible and hassle-free installment plans!</h3>
<p>Explore the world without worrying about upfront costs. Book your dream vacation and pay over time with our exclusive 0% interest installment plan.</p>',
                    'ar' => '<h3>✈️ مزايا السفر</h3>
<ul>
<li><strong>احجز تذاكر الطيران والفنادق وباقات السفر الآن</strong></li>
<li><strong>تقسيط مرن بدون فوائد</strong> – استمتع برحلتك وسدد على دفعات مريحة</li>
<li><strong>العرض حصري</strong> لعمال نقابة DHL البحرينية</li>
</ul>

<p>🚀 لا تفوت الفرصة! سافر، استمتع، وادفع لاحقًا بدون فوائد!</p>

<h3>استمتع برحلتك بدون قلق مع خطة التقسيط الميسرة!</h3>
<p>استكشف العالم دون القلق بشأن التكاليف المقدمة. احجز رحلتك المثالية وادفع على مدى الوقت مع خطة التقسيط الحصرية بدون فوائد.</p>',
                ],
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => [
                    'en' => 'Interest-Free Personal Loan',
                    'ar' => 'قرض شخصي بدون فوائد',
                ],
                'description' => [
                    'en' => 'Get a personal loan with 0% interest to manage your expenses with ease and flexibility.',
                    'ar' => 'احصل على قرض شخصي بدون فوائد لإدارة نفقاتك بكل سهولة ومرونة.',
                ],
                'company_name' => [
                    'en' => 'DHL Financial Services',
                    'ar' => 'الخدمات المالية DHL',
                ],
                'discount' => '0% Interest',
                'offer_description' => [
                    'en' => '<h3>💰 Personal Loan Benefits</h3>
<ul>
<li><strong>Flexible, interest-free financing</strong> – Get the amount you need and repay in convenient installments</li>
<li><strong>Exclusive offer</strong> for DHL Bahraini Trade Union workers</li>
<li><strong>Quick approval process</strong></li>
<li><strong>No hidden fees</strong></li>
</ul>

<h3>Need financial support?</h3>
<p>Now you can get a personal loan with 0% interest, helping you manage your expenses with ease and flexibility!</p>

<p>Whether you need funds for education, home improvements, medical expenses, or any other personal needs, our interest-free personal loan is designed to support you every step of the way.</p>',
                    'ar' => '<h3>💰 مزايا القرض الشخصي</h3>
<ul>
<li><strong>تمويل مرن بدون فوائد</strong> – احصل على المبلغ الذي تحتاجه وسدده على أقساط ميسرة</li>
<li><strong>العرض حصري</strong> لعمال نقابة DHL البحرينية</li>
<li><strong>عملية موافقة سريعة</strong></li>
<li><strong>بدون رسوم مخفية</strong></li>
</ul>

<h3>هل تحتاج إلى دعم مالي؟</h3>
<p>الآن يمكنك الحصول على قرض شخصي بدون فوائد لمساعدتك في تلبية احتياجاتك بكل راحة وسهولة!</p>

<p>سواء كنت بحاجة إلى أموال للتعليم أو تحسينات المنزل أو النفقات الطبية أو أي احتياجات شخصية أخرى، فإن قرضنا الشخصي بدون فوائد مصمم لدعمك في كل خطوة.</p>',
                ],
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'title' => [
                    'en' => 'Exclusive Hotel & Resort Discounts in Bahrain',
                    'ar' => 'خصومات حصرية على الفنادق والمنتجعات في البحرين',
                ],
                'description' => [
                    'en' => 'Enjoy 15-30% discounts at the finest hotels and resorts in Bahrain including spa, dining, and events.',
                    'ar' => 'استمتع بخصومات 15-30% في أفضل الفنادق والمنتجعات في البحرين بما في ذلك السبا والمطاعم والفعاليات.',
                ],
                'company_name' => [
                    'en' => 'Bahrain Premium Hotels',
                    'ar' => 'فنادق البحرين الممتازة',
                ],
                'discount' => 'Up to 30%',
                'offer_description' => [
                    'en' => '<h3>✨ Exclusive Hotel Offers</h3>

<h4>1️⃣ Crowne Plaza Bahrain</h4>
<p>Enjoy <strong>25% – 30% discount</strong> on food and beverages at all hotel outlets by registering in the IHG One Rewards program (free membership).</p>

<h4>2️⃣ The Westin & Le Méridien City Centre Bahrain</h4>
<p>Get <strong>20% off</strong> on all food and beverages at the hotel outlets upon presenting a valid DHL staff ID or company identification card.</p>

<h4>3️⃣ The Diplomat Radisson Blu Hotel</h4>
<ul>
<li>20% off on all restaurants and cafés (excluding alcoholic beverages)</li>
<li>20% off on spa treatments</li>
<li>20% off on swimming pool access or health club membership</li>
<li>20% off on wedding packages</li>
</ul>

<h4>4️⃣ Hilton Bahrain</h4>
<p>Experience the <strong>Tropical Brunch</strong> every Friday from 12:30 PM to 4:00 PM, with live music and special offers.</p>

<h4>5️⃣ The Ritz-Carlton Bahrain</h4>
<ul>
<li>20% off on Cocoon Wellness & Spa treatments</li>
<li>15% off on dry cleaning and laundry services</li>
<li>20% off on food and beverages</li>
<li>20% off on pool access</li>
<li>20% off on meetings and events</li>
</ul>

<h4>6️⃣ The Art Hotel & Resort – Amwaj Islands</h4>
<ul>
<li>20% off on food and beverages</li>
<li>20% off on spa services</li>
<li>Beach access at a special rate of BHD 8 per person</li>
</ul>

<h4>7️⃣ Mövenpick Hotel Bahrain</h4>
<ul>
<li>20% off on food and beverages</li>
<li>20% off on themed dinner nights</li>
<li>20% off on health club membership</li>
<li>20% off on spa and massage treatments</li>
<li>20% off on laundry services</li>
</ul>

<p><strong>Note:</strong> Valid DHL employee ID required at all participating hotels.</p>',
                    'ar' => '<h3>✨ عروض الفنادق الحصرية</h3>

<h4>1️⃣ كراون بلازا البحرين</h4>
<p>استمتع <strong>بخصم 25% – 30%</strong> على الطعام والمشروبات في جميع منافذ الفندق من خلال التسجيل في برنامج IHG One Rewards (عضوية مجانية).</p>

<h4>2️⃣ ذا ويستن و لو ميريديان سيتي سنتر البحرين</h4>
<p>احصل على <strong>خصم 20%</strong> على جميع الأطعمة والمشروبات في منافذ الفندق عند تقديم بطاقة موظف DHL الصالحة أو بطاقة هوية الشركة.</p>

<h4>3️⃣ ذا ديبلومات راديسون بلو</h4>
<ul>
<li>خصم 20% على جميع المطاعم والمقاهي (باستثناء المشروبات الكحولية)</li>
<li>خصم 20% على علاجات السبا</li>
<li>خصم 20% على الدخول إلى المسبح أو عضوية النادي الصحي</li>
<li>خصم 20% على باقات الزفاف</li>
</ul>

<h4>4️⃣ هيلتون البحرين</h4>
<p>استمتع <strong>بالبرانش الاستوائي</strong> كل يوم جمعة من الساعة 12:30 ظهرًا إلى 4:00 مساءً، مع موسيقى حية وعروض خاصة.</p>

<h4>5️⃣ ذا ريتز-كارلتون البحرين</h4>
<ul>
<li>خصم 20% على علاجات كوكون ويلنس آند سبا</li>
<li>خصم 15% على خدمات التنظيف الجاف والغسيل</li>
<li>خصم 20% على الطعام والمشروبات</li>
<li>خصم 20% على الدخول إلى المسبح</li>
<li>خصم 20% على الاجتماعات والفعاليات</li>
</ul>

<h4>6️⃣ فندق ومنتجع الفن – جزر أمواج</h4>
<ul>
<li>خصم 20% على الطعام والمشروبات</li>
<li>خصم 20% على خدمات السبا</li>
<li>الدخول إلى الشاطئ بسعر خاص 8 دينار بحريني للشخص الواحد</li>
</ul>

<h4>7️⃣ موفنبيك البحرين</h4>
<ul>
<li>خصم 20% على الطعام والمشروبات</li>
<li>خصم 20% على ليالي العشاء الموضوعية</li>
<li>خصم 20% على عضوية النادي الصحي</li>
<li>خصم 20% على علاجات السبا والتدليك</li>
<li>خصم 20% على خدمات الغسيل</li>
</ul>

<p><strong>ملاحظة:</strong> مطلوب بطاقة موظف DHL صالحة في جميع الفنادق المشاركة.</p>',
                ],
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        // Create all offers
        foreach ($offers as $offerData) {
            Offer::create($offerData);
        }

        $this->command->info('✅ Successfully seeded '.count($offers).' offers from the offers folder!');
    }
}
