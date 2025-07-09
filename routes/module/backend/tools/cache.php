<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success', 'Cache berhasil dibersihkan!');
})->name('cache.clear')->middleware('auth');
