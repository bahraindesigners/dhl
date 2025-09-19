<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BoardMemberController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Language switching routes
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/language/current', [LanguageController::class, 'current'])->name('language.current');

Route::get('/', [HomePageController::class, 'index'])->name('home');

// Public pages
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/board-member/{boardMember}', [BoardMemberController::class, 'show'])->name('board-member.show');

// Blog routes
Route::get('/news', [BlogController::class, 'index'])->name('blog.index');
Route::get('/news/{blog}', [BlogController::class, 'show'])->name('blog.show');

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
