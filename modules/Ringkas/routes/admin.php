<?php

use Illuminate\Support\Facades\Route;
use Modules\Ringkas\Controllers\RingkasController;



Route::middleware(['web', 'auth', 'permission:atur_ringkas', 'module.active:Ringkas'])
  ->name('ringkas.')
  ->group(function () {
    Route::get('/', [RingkasController::class, 'index'])->name('index');
    Route::get('/create', [RingkasController::class, 'create'])->name('create');
    Route::post('/', [RingkasController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RingkasController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RingkasController::class, 'update'])->name('update');
    Route::delete('/{id}', [RingkasController::class, 'destroy'])->name('destroy');
    Route::get('/data', [RingkasController::class, 'data'])->name('data');
    Route::post('/{id}/status', [RingkasController::class, 'updateStatus'])->name('ringkas.updateStatus');
    Route::get('/stats', [RingkasController::class, 'getStats'])->name('stats');
  });
