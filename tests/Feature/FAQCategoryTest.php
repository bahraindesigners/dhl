<?php

use App\Models\FAQ;
use App\Models\FAQCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create an FAQ category', function () {
    $category = FAQCategory::factory()->create([
        'name' => ['en' => 'Test Category', 'ar' => 'فئة تجريبية'],
        'is_active' => true,
    ]);

    expect($category->getTranslation('name', 'en'))->toBe('Test Category');
    expect($category->getTranslation('name', 'ar'))->toBe('فئة تجريبية');
    expect($category->is_active)->toBeTrue();
});

it('can associate an FAQ with a category', function () {
    $category = FAQCategory::factory()->create([
        'name' => ['en' => 'Test Category', 'ar' => 'فئة تجريبية'],
        'is_active' => true,
    ]);

    $faq = FAQ::create([
        'question' => ['en' => 'Test Question', 'ar' => 'سؤال تجريبي'],
        'answer' => ['en' => 'Test Answer', 'ar' => 'إجابة تجريبية'],
        'faq_category_id' => $category->id,
        'slug' => 'test-question',
        'status' => 'active',
    ]);

    expect($faq->faqCategory)->not->toBeNull();
    expect($faq->faqCategory->id)->toBe($category->id);
    expect($faq->faqCategory->getTranslation('name', 'en'))->toBe('Test Category');
    expect($category->faqs()->count())->toBe(1);
});

it('can filter active FAQ categories', function () {
    FAQCategory::factory()->create(['is_active' => true]);
    FAQCategory::factory()->create(['is_active' => true]);
    FAQCategory::factory()->create(['is_active' => false]);

    $activeCategories = FAQCategory::active()->get();

    expect($activeCategories)->toHaveCount(2);
});

it('orders categories by sort_order', function () {
    $category1 = FAQCategory::factory()->create(['sort_order' => 3]);
    $category2 = FAQCategory::factory()->create(['sort_order' => 1]);
    $category3 = FAQCategory::factory()->create(['sort_order' => 2]);

    $orderedCategories = FAQCategory::ordered()->get();

    expect($orderedCategories->first()->id)->toBe($category2->id);
    expect($orderedCategories->last()->id)->toBe($category1->id);
});
