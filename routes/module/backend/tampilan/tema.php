<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ThemeController;

// PENGATURAN TEMA
Route::prefix('tema')->name('tema.')->middleware(['auth', 'verified', 'permission:edit_tema'])->group(function () {
    Route::get('/', [ThemeController::class, 'index'])->name('index');
    Route::get('/data', [ThemeController::class, 'getTemas'])->name('data');
    Route::post('/{theme}/activate', [ThemeController::class, 'activate'])->name('activate');
    Route::delete('/{theme}', [ThemeController::class, 'destroy'])->name('destroy');
    Route::post('/upload', [ThemeController::class, 'store'])->name('upload.store');
});
