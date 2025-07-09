<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\LinkController;
use App\Http\Controllers\Backend\SubscriptionController;

// Subscribe
Route::middleware(['permission:edit_tautan'])->prefix('blog')->group(function () {
    Route::get('/tautan', [LinkController::class, 'index'])->name('blog.tautan');
    Route::get('/tautan/data', [LinkController::class, 'getTautan'])->name('tautan.data');
    Route::post('/tautan/simpan', [LinkController::class, 'simpanTautan'])->name('tautan.tambah');
    Route::delete('/tautan/{id}', [LinkController::class, 'destroy'])->name('tautan.destroy');
    Route::get('/tautan/{id}/fetch', [LinkController::class, 'fetchTautanById'])->name('tautan.fetch');
    Route::put('/tautan/{id}/update', [LinkController::class, 'update'])->name('tautan.update');

    Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe.index');
    Route::get('/subscribe/data', [SubscriptionController::class, 'getData'])->name('subscribe.data');
});
