<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomePageController::class, 'index'])->name('home');

// Public pages
Route::get('/about', function () {
    return Inertia::render('about');
})->name('about');

Route::get('/news', function () {
    return Inertia::render('news');
})->name('news');

Route::get('/events', function () {
    return Inertia::render('events');
})->name('events');

Route::get('/resources', function () {
    return Inertia::render('resources');
})->name('resources');

Route::get('/contact', function () {
    return Inertia::render('contact');
})->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
