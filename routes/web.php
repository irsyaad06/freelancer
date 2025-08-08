<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;

Route::get('/', function () {
    $web_setting = app(SettingController::class)->title();
    return view('welcome', compact('web_setting'));
});
// Fallback route untuk SPA - menangani semua route Vue Router
Route::fallback(function () {
    return view('welcome');
});
