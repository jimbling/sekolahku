<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Controllers\Frontend\MediaController;

Route::middleware([CheckMaintenanceMode::class])->group(function () {
    Route::get('/unduhan', [MediaController::class, 'unduhan'])->name('web.unduhan');
    Route::get('/cari/files', [MediaController::class, 'search'])->name('web.cari.unduhan');
    Route::get('/unduh/{slug}', [MediaController::class, 'unduhFile'])->name('unduh.file');
});
