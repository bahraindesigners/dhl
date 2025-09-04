<?php

use App\Models\HomeSlider;

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
