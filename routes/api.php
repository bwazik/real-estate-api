<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PropertyController;
use App\Http\Controllers\Api\V1\PropertyImageController;
use App\Http\Controllers\Api\V1\PropertyContactController;
use App\Http\Controllers\Api\V1\PropertyTypeController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\AreaController;
use App\Http\Controllers\Api\V1\PropertyFeatureController;

// API explicitly uses Bearer token authentication
Route::prefix('v1')->name('api.v1.')->group(function () {
    // Public Routes
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Public Supporting Routes (Dropdowns/Filters) with 120 requests/min throttle
    Route::middleware('throttle:120,1')->group(function () {
        Route::get('/property-types', [PropertyTypeController::class, 'index'])->name('property-types.index');
        Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
        Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
        Route::get('/cities/{city}/areas', [AreaController::class, 'cityAreas'])->name('cities.areas');
        Route::get('/property-features', [PropertyFeatureController::class, 'index'])->name('property-features.index');
    });

    // Properties Public Routes with Rate Limiting
    Route::middleware('throttle:60,1')->group(function () {
        Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
        Route::get('/properties/{idOrSlug}', [PropertyController::class, 'show'])->name('properties.show');
    });

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Admin Only Routes
        Route::middleware('admin')->group(function () {
            Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
            Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
            Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

            // Property Images
            Route::post('/properties/{property}/images', [PropertyImageController::class, 'store'])->name('properties.images.store');
            Route::delete('/properties/{property}/images/{image}', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
            Route::put('/properties/{property}/images/{image}/main', [PropertyImageController::class, 'setMain'])->name('properties.images.main');

            // Property Contacts
            Route::post('/properties/{property}/contacts', [PropertyContactController::class, 'store'])->name('properties.contacts.store');
            Route::put('/properties/{property}/contacts/{contact}', [PropertyContactController::class, 'update'])->name('properties.contacts.update');
            Route::delete('/properties/{property}/contacts/{contact}', [PropertyContactController::class, 'destroy'])->name('properties.contacts.destroy');
        });
    });
});
