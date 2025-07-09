<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DokumentasiController;

Route::prefix('dokumentasi')
    ->middleware('permission:atur_modul')
    ->name('documentation.')
    ->group(function () {
        Route::get('/', [DokumentasiController::class, 'index'])->name('index');
        Route::get('/make-module', [DokumentasiController::class, 'module'])->name('module');
        Route::get('/permission', [DokumentasiController::class, 'permission'])->name('permission');
    });
