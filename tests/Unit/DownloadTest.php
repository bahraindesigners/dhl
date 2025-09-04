<?php

use App\Models\Download;

test('download can be instantiated', function () {
    $download = new Download([
        'category' => 'forms',
        'access_level' => 'employees',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    expect($download)->toBeInstanceOf(Download::class);
    expect($download->category)->toBe('forms');
    expect($download->access_level)->toBe('employees');
    expect($download->is_active)->toBeTrue();
    expect($download->sort_order)->toBe(1);
});

test('download active scope works', function () {
    $query = Download::query();
    $query->active();

    expect($query->toSql())->toContain('is_active');
});

test('download ordered scope works', function () {
    $query = Download::query();
    $query->ordered();

    expect($query->toSql())->toContain('sort_order');
});

test('download by category scope works', function () {
    $query = Download::query();
    $query->byCategory('forms');

    expect($query->toSql())->toContain('category');
});

test('download public scope works', function () {
    $query = Download::query();
    $query->public();

    expect($query->toSql())->toContain('access_level');
});

test('download employees only scope works', function () {
    $query = Download::query();
    $query->employeesOnly();

    expect($query->toSql())->toContain('access_level');
});

test('download has correct translatable attributes', function () {
    $download = new Download;

    expect($download->getTranslatableAttributes())->toContain('title');
    expect($download->getTranslatableAttributes())->toContain('description');
});

test('download has correct fillable attributes', function () {
    $download = new Download;

    expect($download->getFillable())->toContain('title');
    expect($download->getFillable())->toContain('description');
    expect($download->getFillable())->toContain('category');
    expect($download->getFillable())->toContain('access_level');
    expect($download->getFillable())->toContain('is_active');
    expect($download->getFillable())->toContain('sort_order');
});

test('download file size formatted method works', function () {
    $download = new Download(['file_size' => 1024]);
    expect($download->getFileSizeFormatted())->toBe('1 KB');

    $download = new Download(['file_size' => 1048576]);
    expect($download->getFileSizeFormatted())->toBe('1 MB');

    $download = new Download(['file_size' => null]);
    expect($download->getFileSizeFormatted())->toBe('Unknown');
});

test('download category label method works', function () {
    $download = new Download(['category' => 'forms']);
    expect($download->getCategoryLabel())->toBe('Forms & Documents');

    $download = new Download(['category' => 'policies']);
    expect($download->getCategoryLabel())->toBe('Policies & Procedures');

    $download = new Download(['category' => 'unknown']);
    expect($download->getCategoryLabel())->toBe('Unknown');
});

test('download access level label method works', function () {
    $download = new Download(['access_level' => 'public']);
    expect($download->getAccessLevelLabel())->toBe('Public Access');

    $download = new Download(['access_level' => 'employees']);
    expect($download->getAccessLevelLabel())->toBe('Employees Only');

    $download = new Download(['access_level' => 'managers']);
    expect($download->getAccessLevelLabel())->toBe('Managers Only');

    $download = new Download(['access_level' => 'admin']);
    expect($download->getAccessLevelLabel())->toBe('Admin Only');
});
