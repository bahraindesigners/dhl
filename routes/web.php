<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BoardMemberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Language switching routes
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/language/current', [LanguageController::class, 'current'])->name('language.current');

Route::get('/', [HomePageController::class, 'index'])->name('home');

// Public pages
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/membership', [MembershipController::class, 'index'])->name('membership')->middleware('auth');
Route::post('/membership', [MembershipController::class, 'store'])->name('membership.store')->middleware('auth');
Route::get('/board-member/{boardMember}', [BoardMemberController::class, 'show'])->name('board-member.show');

// Blog routes
Route::get('/news', [BlogController::class, 'index'])->name('blog.index');
Route::get('/news/{blog}', [BlogController::class, 'show'])->name('blog.show');

// Event routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Event registration routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::post('/events/{event}/register', [EventRegistrationController::class, 'store'])->name('events.register');
    Route::get('/events/{event}/registration/{registration}', [EventRegistrationController::class, 'show'])->name('events.registration.show');
    Route::delete('/events/{event}/registration/{registration}', [EventRegistrationController::class, 'destroy'])->name('events.registration.cancel');
});

// Resources routes
Route::get('/resources', [ResourceController::class, 'index'])->name('resources');
Route::get('/resources/{download}/view', [ResourceController::class, 'view'])->name('resources.view');
Route::get('/resources/{download}/download', [ResourceController::class, 'download'])->name('resources.download');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
