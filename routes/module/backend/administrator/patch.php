<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PatchController;

Route::prefix('patch')->group(function () {
    Route::get('/update', [PatchController::class, 'index'])->name('patch.index');
    Route::post('/upload', [PatchController::class, 'upload'])->name('patch.upload');

    Route::post('/check-update', [PatchController::class, 'checkForUpdate'])
        ->middleware(['permission:edit_pemeliharaan', 'throttle:5,1'])
        ->name('patch.check');
});
