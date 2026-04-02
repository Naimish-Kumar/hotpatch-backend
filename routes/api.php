<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Health check
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'service' => 'hotpatch-api-laravel']);
});

// Billing Webhook
Route::post('/billing/webhook', [PaymentController::class, 'webhook']);

// Public
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{slug}', [BlogController::class, 'show']);
Route::get('/packages', [PricingController::class, 'list']);

// Auth
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/token', [AuthController::class, 'issueTokenFromApiKey']);
});

// Authenticated
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Superadmin routes
    Route::prefix('admin')->group(function () {
        Route::get('/stats', [AdminController::class, 'index']);
        Route::get('/apps', [AdminController::class, 'apps']);
        Route::get('/users', [AdminController::class, 'users']);
        Route::get('/blogs', [AdminController::class, 'blogs']);
        Route::post('/blogs', [AdminController::class, 'createBlog']);
        Route::patch('/blogs/{id}', [AdminController::class, 'updateBlog']);
        Route::delete('/blogs/{id}', [AdminController::class, 'deleteBlog']);
    });

    // Releases
    Route::post('/releases', [ReleaseController::class, 'store']);
    Route::get('/releases', [ReleaseController::class, 'index']);
    Route::get('/releases/{id}', [ReleaseController::class, 'show']);
    Route::patch('/releases/{id}/rollout', [ReleaseController::class, 'updateRollout']);
    Route::patch('/releases/{id}/rollback', [ReleaseController::class, 'rollback']);
    Route::delete('/releases/{id}', [ReleaseController::class, 'destroy']);
    Route::post('/releases/{id}/patches', [ReleaseController::class, 'addPatch']);

    // Devices
    Route::get('/devices', [DeviceController::class, 'index']);

    // Security
    Route::post('/security/api-keys', [SecurityController::class, 'createApiKey']);
    Route::delete('/security/api-keys/{id}', [SecurityController::class, 'deleteApiKey']);
    Route::post('/security/signing-keys', [SecurityController::class, 'createSigningKey']);
    Route::delete('/security/signing-keys/{id}', [SecurityController::class, 'deleteSigningKey']);

    // Settings
    Route::patch('/settings/app', [SettingsController::class, 'updateApp']);
    Route::get('/settings/webhooks', [SettingsController::class, 'listWebhooks']);
    Route::post('/settings/webhooks', [SettingsController::class, 'createWebhook']);
    Route::delete('/settings/webhooks/{id}', [SettingsController::class, 'deleteWebhook']);

    // Billing
    Route::post('/billing/checkout', [PaymentController::class, 'checkout']);
    Route::post('/billing/portal', [PaymentController::class, 'portal']);
});

// SDK/CLI routes
Route::get('/update/check', [UpdateController::class, 'check']);
