<?php

use App\Http\Controllers\WebController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// ─── Public pages ───
Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/docs', [WebController::class, 'docs'])->name('docs');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// ─── Auth (guests only) ───
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'webLogin']);
    Route::get('/register', [WebController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'webRegister']);

    // Google Sign-in
    Route::get('/auth/google', [\App\Http\Controllers\Auth\SocialController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\SocialController::class, 'handleGoogleCallback']);
});

// ─── Auth (logged-in) ───
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout')->middleware('auth');

// ─── Dashboard (session auth) ───
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/analytics/trends', [DashboardController::class, 'getTrends']);
    Route::get('/dashboard/analytics/distribution', [DashboardController::class, 'getDistribution']);
    Route::get('/dashboard/releases', [ReleaseController::class, 'webIndex'])->name('releases');
    Route::get('/dashboard/devices', [DeviceController::class, 'webIndex'])->name('devices');
    Route::get('/dashboard/security', [SecurityController::class, 'webIndex'])->name('security');
    Route::get('/dashboard/settings', [SettingsController::class, 'webIndex'])->name('settings');
    Route::post('/dashboard/settings', [SettingsController::class, 'webUpdate']);
    Route::get('/dashboard/billing', [PaymentController::class, 'webIndex'])->name('billing');

    // Admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/apps', [AdminController::class, 'apps'])->name('admin.apps');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/blogs', [AdminController::class, 'blogs'])->name('admin.blogs');
});
