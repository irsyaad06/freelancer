<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceGalleryController;
use App\Http\Controllers\Api\ServicePackageController;

Route::prefix('layanan')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{id}', [ServiceController::class, 'show']);
});

Route::prefix('kategori')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
});

Route::prefix('subkategori')->group(function () {
    Route::get('/', [SubcategoryController::class, 'index']);
    Route::get('/{id}', [SubcategoryController::class, 'show']);
});

Route::prefix('freelancer')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
});

Route::prefix('service-gallery')->group(function () {
    Route::get('/', [ServiceGalleryController::class, 'index']);
    Route::get('/user/{userId}', [ServiceGalleryController::class, 'getByUserId']);
    Route::get('/{id}', [ServiceGalleryController::class, 'show']);
});

Route::prefix('package')->group(function () {
    Route::get('/', [ServicePackageController::class, 'index']);
    Route::get('/{id}', [ServicePackageController::class, 'show']);
});
