<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Controllers\Frontend\DirektoriController;

Route::middleware([CheckMaintenanceMode::class])->group(function () {
    Route::get('/guru-tendik', [DirektoriController::class, 'gtk'])->name('web.gtk');
    Route::get('/api/gtk', [DirektoriController::class, 'gtkData']);
    Route::get('/api/gtk/{id}', [DirektoriController::class, 'gtkDetail']);
    Route::get('/peserta-didik', [DirektoriController::class, 'peserta_didik'])->name('web.pd');
    Route::get('/pd-non-aktif', [DirektoriController::class, 'peserta_didik_non_aktif'])->name('web.pd.non.active');
    Route::get('/pd/nonaktif', [DirektoriController::class, 'nonaktif'])->middleware('throttle:60,1');
    Route::post('/pd/filter', [DirektoriController::class, 'filterPesertaDidik'])->name('web.pd.filter');
});
