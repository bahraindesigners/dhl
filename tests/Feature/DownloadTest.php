<?php

use App\Models\Download;

test('download can be created', function () {
    $download = Download::factory()->create([
        'title' => [
            'en' => 'Test Download',
            'ar' => 'تحميل تجريبي',
        ],
        'category' => 'forms',
        'access_level' => 'employees',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    expect($download)->toBeInstanceOf(Download::class);
    expect($download->getTranslation('title', 'en'))->toBe('Test Download');
    expect($download->getTranslation('title', 'ar'))->toBe('تحميل تجريبي');
    expect($download->category)->toBe('forms');
    expect($download->access_level)->toBe('employees');
    expect($download->is_active)->toBeTrue();
    expect($download->sort_order)->toBe(1);
});

test('download scopes work correctly', function () {
    Download::factory()->create(['is_active' => true, 'category' => 'forms', 'access_level' => 'public', 'sort_order' => 1]);
    Download::factory()->create(['is_active' => false, 'category' => 'policies', 'access_level' => 'employees', 'sort_order' => 2]);
    Download::factory()->create(['is_active' => true, 'category' => 'forms', 'access_level' => 'public', 'sort_order' => 3]);

    $activeDownloads = Download::active()->get();
    expect($activeDownloads)->toHaveCount(2);

    $formsDownloads = Download::byCategory('forms')->get();
    expect($formsDownloads)->toHaveCount(2);

    $publicDownloads = Download::public()->get();
    expect($publicDownloads)->toHaveCount(2);

    $employeesOnlyDownloads = Download::employeesOnly()->get();
    expect($employeesOnlyDownloads)->toHaveCount(1);

    $orderedDownloads = Download::ordered()->get();
    expect($orderedDownloads->first()->sort_order)->toBe(1);
    expect($orderedDownloads->last()->sort_order)->toBe(3);

    $activeFormsDownloads = Download::active()->byCategory('forms')->get();
    expect($activeFormsDownloads)->toHaveCount(2);
});

test('download media methods work', function () {
    $download = Download::factory()->create();

    expect($download->hasFile())->toBeFalse();
    expect($download->getFileUrl())->toBe('');
    expect($download->getFileName())->toBeNull();
    expect($download->getFileExtension())->toBeNull();
});

test('download count can be incremented', function () {
    $download = Download::factory()->create(['download_count' => 5]);

    expect($download->download_count)->toBe(5);

    $download->incrementDownloadCount();

    expect($download->fresh()->download_count)->toBe(6);
});

test('download factory creates valid data', function () {
    $download = Download::factory()->create();

    expect($download->getTranslations('title'))->toBeArray();
    expect($download->getTranslations('title'))->toHaveKey('en');
    expect($download->getTranslations('title'))->toHaveKey('ar');
    expect($download->getTranslations('description'))->toBeArray();
    expect($download->getTranslations('description'))->toHaveKey('en');
    expect($download->getTranslations('description'))->toHaveKey('ar');
    expect($download->category)->toBeString();
    expect($download->access_level)->toBeString();
    expect($download->is_active)->toBeBool();
    expect($download->sort_order)->toBeInt();
    expect($download->download_count)->toBeInt();
});

test('download factory states work', function () {
    $activeDownload = Download::factory()->active()->create();
    expect($activeDownload->is_active)->toBeTrue();

    $inactiveDownload = Download::factory()->inactive()->create();
    expect($inactiveDownload->is_active)->toBeFalse();

    $formsDownload = Download::factory()->category('forms')->create();
    expect($formsDownload->category)->toBe('forms');

    $publicDownload = Download::factory()->public()->create();
    expect($publicDownload->access_level)->toBe('public');

    $employeesDownload = Download::factory()->employeesOnly()->create();
    expect($employeesDownload->access_level)->toBe('employees');
});
