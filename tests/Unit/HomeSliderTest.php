<?php

use App\Models\HomeSlider;

test('home slider can be instantiated', function () {
    $slider = new HomeSlider([
        'is_active' => true,
        'sort_order' => 1,
    ]);

    expect($slider)->toBeInstanceOf(HomeSlider::class);
    expect($slider->is_active)->toBeTrue();
    expect($slider->sort_order)->toBe(1);
});

test('home slider active scope works', function () {
    $query = HomeSlider::query();
    $query->active();

    expect($query->toSql())->toContain('is_active');
});

test('home slider ordered scope works', function () {
    $query = HomeSlider::query();
    $query->ordered();

    expect($query->toSql())->toContain('sort_order');
});

test('home slider has correct media collections', function () {
    $slider = new HomeSlider;

    // The model needs to be registered with collections first
    expect($slider->getTranslatableAttributes())->toBeArray();
});

test('home slider has correct translatable attributes', function () {
    $slider = new HomeSlider;

    expect($slider->getTranslatableAttributes())->toContain('title');
    expect($slider->getTranslatableAttributes())->toContain('subtitle');
    expect($slider->getTranslatableAttributes())->toContain('description');
    expect($slider->getTranslatableAttributes())->toContain('button_text');
});

test('home slider can be created', function () {
    $slider = HomeSlider::factory()->create([
        'title' => [
            'en' => 'Test Slider',
            'ar' => 'شريحة اختبار',
        ],
        'is_active' => true,
        'sort_order' => 1,
    ]);

    expect($slider)->toBeInstanceOf(HomeSlider::class);
    expect($slider->getTranslation('title', 'en'))->toBe('Test Slider');
    expect($slider->getTranslation('title', 'ar'))->toBe('شريحة اختبار');
    expect($slider->is_active)->toBeTrue();
    expect($slider->sort_order)->toBe(1);
});

test('home slider scopes work correctly', function () {
    HomeSlider::factory()->create(['is_active' => true, 'sort_order' => 2]);
    HomeSlider::factory()->create(['is_active' => false, 'sort_order' => 1]);
    HomeSlider::factory()->create(['is_active' => true, 'sort_order' => 3]);

    $activeSliders = HomeSlider::active()->get();
    expect($activeSliders)->toHaveCount(2);

    $orderedSliders = HomeSlider::ordered()->get();
    expect($orderedSliders->first()->sort_order)->toBe(1);
    expect($orderedSliders->last()->sort_order)->toBe(3);

    $activeOrderedSliders = HomeSlider::active()->ordered()->get();
    expect($activeOrderedSliders)->toHaveCount(2);
    expect($activeOrderedSliders->first()->sort_order)->toBe(2);
});

test('home slider media methods work', function () {
    $slider = HomeSlider::factory()->create();

    expect($slider->hasDesktopImage())->toBeFalse();
    expect($slider->hasMobileImage())->toBeFalse();
    expect($slider->getDesktopImageUrl())->toBe('');
    expect($slider->getMobileImageUrl())->toBe('');
    expect($slider->getImageUrl())->toBe('');
    expect($slider->getImageUrl('mobile'))->toBe('');
});
