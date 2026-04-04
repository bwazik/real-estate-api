<?php

use App\Http\Controllers\Api\V1\AreaController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\ComplaintController;
use App\Http\Controllers\Api\V1\PropertyContactController;
use App\Http\Controllers\Api\V1\PropertyController;
use App\Http\Controllers\Api\V1\PropertyFeatureController;
use App\Http\Controllers\Api\V1\PropertyImageController;
use App\Http\Controllers\Api\V1\PropertyTypeController;
use App\Http\Controllers\Api\V1\SiteContentController;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API explicitly uses Bearer token authentication
Route::prefix('v1')->name('api.v1.')->group(function () {
    // Public Routes
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');

    // Public Supporting Routes (Dropdowns/Filters) with 120 requests/min throttle
    Route::middleware('throttle:api')->group(function () {
        Route::get('/property-types', [PropertyTypeController::class, 'index'])->name('property-types.index');
        Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
        Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
        Route::get('/cities/{city:slug}/areas', [AreaController::class, 'cityAreas'])->name('cities.areas');
        Route::get('/property-features', [PropertyFeatureController::class, 'index'])->name('property-features.index');
    });

    // Properties Public Routes with Rate Limiting
    Route::middleware('throttle:api')->group(function () {
        Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
        Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');
        Route::get('/site-content/{group}', [SiteContentController::class, 'getByGroup'])->name('site-content.group');
    });

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/user', function (Request $request) {
            return new UserResource($request->user());
        });

        // Admin Only Routes
        Route::middleware('admin')->group(function () {
            Route::put('/site-content', [SiteContentController::class, 'update'])->name('site-content.update');
            Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
            Route::put('/properties/{property:slug}', [PropertyController::class, 'update'])->name('properties.update');
            Route::delete('/properties/{property:slug}', [PropertyController::class, 'destroy'])->name('properties.destroy');

            // Property Images
            Route::post('/properties/{property:slug}/images', [PropertyImageController::class, 'store'])->name('properties.images.store');
            Route::delete('/properties/{property:slug}/images/{image:uuid}', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
            Route::put('/properties/{property:slug}/images/{image:uuid}/main', [PropertyImageController::class, 'setMain'])->name('properties.images.main');

            // Property Contacts
            Route::post('/properties/{property:slug}/contacts', [PropertyContactController::class, 'store'])->name('properties.contacts.store');
            Route::put('/properties/{property:slug}/contacts/{contact:uuid}', [PropertyContactController::class, 'update'])->name('properties.contacts.update');
            Route::delete('/properties/{property:slug}/contacts/{contact:uuid}', [PropertyContactController::class, 'destroy'])->name('properties.contacts.destroy');

            // Complaints
            Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
            Route::get('/complaints/{complaint:uuid}', [ComplaintController::class, 'show'])->name('complaints.show');
            Route::put('/complaints/{complaint:uuid}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.status');
            Route::put('/complaints/{complaint:uuid}/read', [ComplaintController::class, 'markAsRead'])->name('complaints.read');
        });
    });
});
