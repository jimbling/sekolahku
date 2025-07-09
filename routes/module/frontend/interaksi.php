<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Backend\MessageController;

Route::middleware([CheckMaintenanceMode::class])->group(function () {
    Route::post('/kirim-pesan', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
});
