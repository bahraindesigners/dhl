<?php

use App\Models\About;

beforeEach(function () {
    // Allow constraint bypassing during test setup
    About::$skipConstraints = true;

    // Clear any existing About records first
    About::query()->forceDelete();

    $this->about = About::factory()->create([
        'title' => [
            'en' => 'About DHL Bahrain Trade Union',
            'ar' => 'حول اتحاد دي إتش إل البحرين',
        ],
        'content' => [
            'en' => '<p>DHL is a global logistics company.</p>',
            'ar' => '<p>دي إتش إل هي شركة لوجستية عالمية.</p>',
        ],
        'show_board_section' => true,
        'board_section_title' => [
            'en' => 'Board of Directors',
            'ar' => 'مجلس الإدارة',
        ],
        'board_section_description' => [
            'en' => '<p>Our leadership team.</p>',
            'ar' => '<p>فريق القيادة لدينا.</p>',
        ],
    ]);

    // Re-enable constraints for the actual tests
    About::$skipConstraints = false;
});

it('can create an about page', function () {
    // Use the existing about page created in beforeEach
    expect($this->about->exists)->toBeTrue();
    expect($this->about->getTranslations('title'))->toBeArray();
    expect($this->about->getTranslations('content'))->toBeArray();
});
it('has translatable attributes', function () {
    expect($this->about->getTranslatableAttributes())
        ->toBe(['title', 'content', 'board_section_title', 'board_section_description']);
});

it('returns translated title', function () {
    app()->setLocale('en');
    expect($this->about->title)->toBe('About DHL');

    app()->setLocale('ar');
    expect($this->about->title)->toBe('حول دي إتش إل');
});

it('returns translated content', function () {
    app()->setLocale('en');
    expect($this->about->content)->toBe('<p>DHL is a global logistics company.</p>');

    app()->setLocale('ar');
    expect($this->about->content)->toBe('<p>دي إتش إل هي شركة لوجستية عالمية.</p>');
});

it('returns translated board section title when enabled', function () {
    app()->setLocale('en');
    expect($this->about->board_section_title)->toBe('Board of Directors');

    app()->setLocale('ar');
    expect($this->about->board_section_title)->toBe('مجلس الإدارة');
});

it('returns translated board section description when enabled', function () {
    app()->setLocale('en');
    expect($this->about->board_section_description)->toBe('<p>Our leadership team.</p>');

    app()->setLocale('ar');
    expect($this->about->board_section_description)->toBe('<p>فريق القيادة لدينا.</p>');
});

it('can toggle board section visibility', function () {
    expect($this->about->show_board_section)->toBeTrue();

    $this->about->update(['show_board_section' => false]);

    expect($this->about->fresh()->show_board_section)->toBeFalse();
});

it('can scope active records', function () {
    // We can only have one About page, so let's test with the existing one
    $this->about->update(['is_active' => true]);

    expect(About::active()->count())->toBe(1);

    // Test inactive
    $this->about->update(['is_active' => false]);
    expect(About::active()->count())->toBe(0);
});

it('can scope by board section', function () {
    // Test with board section enabled
    $this->about->update(['show_board_section' => true]);
    expect(About::withBoardSection()->count())->toBe(1);

    // Test with board section disabled
    $this->about->update(['show_board_section' => false]);
    expect(About::withBoardSection()->count())->toBe(0);
});
it('can be deactivated', function () {
    $this->about->update(['is_active' => false]);

    expect($this->about->fresh()->is_active)->toBeFalse();
});

it('has proper fillable attributes', function () {
    $fillable = [
        'title',
        'content',
        'show_board_section',
        'board_section_title',
        'board_section_description',
        'is_active',
        'sort_order',
    ];

    expect($this->about->getFillable())->toEqual($fillable);
});

it('casts attributes correctly', function () {
    expect($this->about->getCasts())->toHaveKey('show_board_section');
    expect($this->about->getCasts())->toHaveKey('is_active');
    expect($this->about->getCasts())->toHaveKey('sort_order');
});

it('can get main about page', function () {
    // Since we can only have one About page, the main page should be the existing one
    $mainPage = About::getMainAboutPage();

    expect($mainPage)->not->toBeNull();
    expect($mainPage->id)->toBe($this->about->id);
    expect($mainPage->is_active)->toBeTrue();
});

it('prevents creating multiple about pages', function () {
    // First about page should be created successfully
    About::$skipConstraints = true;
    $firstAbout = About::factory()->create();
    About::$skipConstraints = false;

    expect($firstAbout->exists)->toBeTrue();

    // Trying to create a second about page should throw an exception
    expect(fn () => About::factory()->create())
        ->toThrow(\Exception::class, 'Only one About page is allowed. Please edit the existing one.');
});

it('prevents deleting the only about page', function () {
    // Create a single about page
    About::$skipConstraints = true;
    About::query()->forceDelete(); // Clear first
    $about = About::factory()->create();
    About::$skipConstraints = false;

    // Trying to delete the only about page should throw an exception
    expect(fn () => $about->delete())
        ->toThrow(\Exception::class, 'Cannot delete the About page. At least one About page must exist.');
});

it('can get single instance', function () {
    // Should return the existing instance since we can't delete it
    $about = About::getSingleInstance();
    expect($about->exists)->toBeTrue();
    expect($about->getTranslations('title'))->toHaveKey('en');
    expect($about->getTranslations('title'))->toHaveKey('ar');

    // Should return the same instance if called again
    $sameAbout = About::getSingleInstance();
    expect($sameAbout->id)->toBe($about->id);
});
