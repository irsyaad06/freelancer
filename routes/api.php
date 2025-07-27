<?php

use App\Http\Controllers\Api\FreelancerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ServiceGalleryController;
use App\Http\Controllers\Api\ServicePackageController;


Route::prefix('kategori')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
});

Route::prefix('subkategori')->group(function () {
    Route::get('/', [SubcategoryController::class, 'index']);
    Route::get('/{id}', [SubcategoryController::class, 'show']);
});


Route::prefix('freelancer')->group(function () {
    Route::get('/', [FreelancerController::class, 'index']);
    Route::get('/subkategori/{subcategory_id}', [FreelancerController::class, 'freelancerBySubcategory']);
    // Route::get('/{id}', [FreelancerController::class, 'show']);
});
Route::prefix('jasa')->group(function () {
    Route::get('/{subcategory_id}/freelancer/{freelancer_id}', [FreelancerController::class, 'freelancerDetailBySubcategory']);
});
Route::prefix('layanan')->group(function () {
    Route::get('/', [ServicePackageController::class, 'index']);
    Route::get('/{id}', [ServicePackageController::class, 'show']);
});
