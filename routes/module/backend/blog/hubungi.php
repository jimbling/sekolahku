<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\MessageController;

// Hubungi Kami
Route::middleware(['permission:edit_hubungi'])->group(function () {
    Route::prefix('contact')->group(function () {
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/admin/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
        Route::get('/messages/data', [MessageController::class, 'getData'])->name('messages.data');
        Route::post('/admin/messages/{id}/reply', [MessageController::class, 'storeReply'])->name('messages.reply');
    });
});
