<?php

use App\Models\Download;
use App\Models\DownloadCategory;

it('can create a download category', function () {
    $category = DownloadCategory::factory()->create([
        'name' => ['en' => 'Test Category', 'ar' => 'فئة الاختبار'],
        'description' => ['en' => 'Test description', 'ar' => 'وصف الاختبار'],
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    expect($category->name)->toBe('Test Category');
    expect($category->description)->toBe('Test description');
    expect($category->slug)->toBe('test-category');
    expect($category->is_active)->toBeTrue();
});

it('can retrieve download categories with active scope', function () {
    DownloadCategory::factory()->create(['is_active' => true]);
    DownloadCategory::factory()->create(['is_active' => false]);

    $activeCategories = DownloadCategory::active()->get();

    expect($activeCategories)->toHaveCount(1);
    expect($activeCategories->first()->is_active)->toBeTrue();
});

it('can order download categories by sort order', function () {
    $category1 = DownloadCategory::factory()->create(['sort_order' => 3]);
    $category2 = DownloadCategory::factory()->create(['sort_order' => 1]);
    $category3 = DownloadCategory::factory()->create(['sort_order' => 2]);

    $orderedCategories = DownloadCategory::ordered()->get();

    expect($orderedCategories->pluck('sort_order')->toArray())->toBe([1, 2, 3]);
});

it('can associate downloads with download categories', function () {
    $category = DownloadCategory::factory()->create();
    $download = Download::factory()->create(['download_category_id' => $category->id]);

    expect($download->downloadCategory)->toBeInstanceOf(DownloadCategory::class);
    expect($download->downloadCategory->id)->toBe($category->id);
    expect($category->downloads)->toHaveCount(1);
    expect($category->downloads->first()->id)->toBe($download->id);
});

it('can handle bilingual translations', function () {
    $category = DownloadCategory::factory()->create([
        'name' => ['en' => 'English Name', 'ar' => 'الاسم العربي'],
    ]);

    app()->setLocale('en');
    expect($category->name)->toBe('English Name');

    app()->setLocale('ar');
    expect($category->name)->toBe('الاسم العربي');
});
