# Offers Content Seeding Guide

## Overview
This guide explains how to populate the Offers section with real company partnership offers in both English and Arabic.

## Database Structure
- **7 Real Offers** from actual partner companies
- **All content bilingual** (English & Arabic)
- **Rich HTML descriptions** with formatting, lists, and contact information

## Offers Included

### 1️⃣ Clear Vision Optical
- **Discount:** Up to 50%
- **Services:** Frames, sunglasses, prescription lenses, eye exams
- **Special:** Free annual eye exam + free contact lens trial

### 2️⃣ Alkuwaiti Auto Service
- **Discount:** Up to 25%
- **Services:** Tires, batteries, car wash, maintenance
- **Special:** Free oil filter change + 0% installment on tires
- **Locations:** 13 branches across Bahrain

### 3️⃣ Salam Gas
- **Discount:** 0% Interest Installment Plans
- **Services:** Gas supplies and equipment
- **Contact:** Multiple channels (phone, WhatsApp, maintenance)

### 4️⃣ Zenet Electronics
- **Discount:** 0% Interest Installment Plans
- **Services:** Electronics, home appliances, air conditioning
- **Locations:** Multiple showrooms including Dragon Mall

### 5️⃣ Travel Services
- **Discount:** 0% Interest Installment Plans
- **Services:** Flight tickets, hotels, travel packages
- **Benefit:** Travel now, pay later with flexible installments

### 6️⃣ Personal Loans
- **Discount:** 0% Interest
- **Services:** Interest-free personal loans for union members
- **Features:** Flexible repayment, quick approval, no hidden fees

### 7️⃣ Premium Hotels & Resorts
- **Discount:** 15-30%
- **Partners:** 7 premium hotels in Bahrain
  - Crowne Plaza (25-30% off)
  - Westin & Le Méridien (20% off)
  - Diplomat Radisson Blu (20% off)
  - Hilton Bahrain (Special brunch offers)
  - Ritz-Carlton (20% off on spa, dining, events)
  - The Art Hotel & Resort (20% off + beach access)
  - Mövenpick Hotel (20% off on multiple services)

## Running the Seeder

### Option 1: Run the Seeder Directly
```bash
php artisan db:seed --class=OfferContentSeeder
```

### Option 2: Clear Existing Offers First (if needed)
```bash
php artisan tinker
```
```php
\App\Models\Offer::where('id', '>', 1)->delete();
exit
```
```bash
php artisan db:seed --class=OfferContentSeeder
```

### Option 3: Add to DatabaseSeeder (for fresh installations)
Edit `database/seeders/DatabaseSeeder.php`:
```php
public function run(): void
{
    $this->call([
        // ... other seeders
        OfferContentSeeder::class,
    ]);
}
```

Then run:
```bash
php artisan db:seed
```

## What Gets Created

### Each Offer Includes:
- ✅ **English title** - Clear, descriptive offer name
- ✅ **Arabic title** - Full Arabic translation
- ✅ **English description** - Short summary
- ✅ **Arabic description** - Translated summary
- ✅ **Company name** - Bilingual partner name
- ✅ **Discount** - Clear discount percentage or terms
- ✅ **Rich HTML content** - Full offer details with:
  - Formatted headings (H3, H4)
  - Bullet lists
  - Contact information
  - Links (phone, website, Instagram)
  - Special terms and conditions
- ✅ **Active status** - All offers are active by default
- ✅ **Sort order** - Properly ordered for display

## Verify the Data

### Check counts:
```bash
php artisan tinker
```

```php
\App\Models\Offer::count(); // Should return 8 (including UFC Gym)
\App\Models\Offer::where('is_active', true)->count(); // Should return 8
```

### View all offers:
```php
$offers = \App\Models\Offer::orderBy('sort_order')->get();
$offers->map(function($offer) {
    return [
        'title_en' => $offer->getTranslation('title', 'en'),
        'company_en' => $offer->getTranslation('company_name', 'en'),
        'discount' => $offer->discount,
        'is_active' => $offer->is_active
    ];
});
```

### View detailed offer content:
```php
$offer = \App\Models\Offer::find(2);
return [
    'title_en' => $offer->getTranslation('title', 'en'),
    'title_ar' => $offer->getTranslation('title', 'ar'),
    'description_en' => $offer->getTranslation('description', 'en'),
    'description_ar' => $offer->getTranslation('description', 'ar'),
    'company_en' => $offer->getTranslation('company_name', 'en'),
    'discount' => $offer->discount,
];
```

## View on Website
After seeding, visit:
- **English**: `https://dhl.test/offers`
- **Arabic**: `https://dhl.test/ar/offers`

## Managing Offers via Filament Admin
You can manage all offers through the Filament admin panel:
1. Log in to `/admin`
2. Navigate to **Offers**
3. Edit, add, or remove offers as needed
4. Use the rich text editor for `offer_description` field

## Source Files
The original offer data was sourced from:
- `offers/offer-1.txt` - Clear Vision Optical
- `offers/offer-2.txt` - Alkuwaiti Auto Service
- `offers/offer-3.txt` - Salam Gas
- `offers/offer-4.txt` - Zenet Electronics
- `offers/offer-5.txt` - Travel Services
- `offers/offer-6.txt` - Personal Loans
- `offers/offer-7.txt` - Premium Hotels

## Important Notes

### Translation Support
- All fields support both English and Arabic
- Translations handled by Spatie Translatable package
- Content automatically displays based on user's language

### Rich Content Rendering
- Offer descriptions use HTML formatting
- Backend converts TipTap JSON to HTML using `RichContentRenderer`
- Frontend displays formatted content with proper styling

### Contact Information
Each offer includes relevant contact details:
- 📞 Phone numbers
- 📍 Locations/addresses
- 🌐 Websites
- 📸 Instagram handles
- 💬 WhatsApp numbers (where applicable)

## Customization

To modify the content, edit:
```
database/seeders/OfferContentSeeder.php
```

Then clear existing offers and re-run:
```bash
php artisan tinker
```
```php
\App\Models\Offer::where('id', '>', 1)->delete();
exit
```
```bash
php artisan db:seed --class=OfferContentSeeder
```

## Success Confirmation
After running the seeder, you should see:
```
✅ Successfully seeded 7 offers from the offers folder!
```

## Troubleshooting

### Problem: Duplicate entries
**Solution**: Delete existing offers before re-running:
```php
\App\Models\Offer::where('id', '>', 1)->delete();
```

### Problem: Translations not showing
**Solution**: Clear Laravel cache:
```bash
php artisan cache:clear
php artisan config:clear
```

### Problem: Offers not visible on frontend
**Solution**: Check that:
1. Offers have `is_active = true`
2. OfferController is rendering properly
3. Frontend route is configured correctly

### Problem: Rich content not displaying
**Solution**: Verify that:
1. `OfferController` uses `RichContentRenderer`
2. Frontend uses `dangerouslySetInnerHTML` or proper HTML rendering
3. Content is being converted from TipTap JSON to HTML

## Additional Resources
- Seeder file: `database/seeders/OfferContentSeeder.php`
- Offer Model: `app/Models/Offer.php`
- Offer Controller: `app/Http/Controllers/OfferController.php`
- Frontend Component: `resources/js/pages/Offers/index.tsx`
- Offer Detail Page: `resources/js/pages/Offers/show.tsx`

## Partner Contact Quick Reference

| Partner | Phone | Website | Instagram |
|---------|-------|---------|-----------|
| Clear Vision | 33950201 | clearvisionme.com | @clearvisionoptics |
| Alkuwaiti Auto | 80408888 | - | @alkuwaiti_auto_service |
| Salam Gas | 17401212 / 13306660 | - | @alsalambah |
| Zenet Electronics | 17224220 / 17702103 | zenet.net | @zenetelectronics |

---

**Note:** This seeder complements the existing UFC Gym offer (ID: 1) and adds 7 new partner offers for a total of 8 active offers on the platform.
