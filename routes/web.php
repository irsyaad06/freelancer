<?php

use Illuminate\Support\Facades\Route;

// Route untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Fallback route untuk SPA - menangani semua route Vue Router
Route::fallback(function () {
    return view('welcome');
});
