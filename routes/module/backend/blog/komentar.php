<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

// Komentar
Route::middleware(['permission:edit_komentar'])->prefix('blog')->group(function () {
    Route::get('/komentar', [CommentController::class, 'index'])->name('blog.comments.index');
    Route::post('/komentar/reply/{comment}', [CommentController::class, 'reply'])->name('blog.komentar.reply');
    Route::put('/komentar/{comment}/approve', [CommentController::class, 'approve'])->name('blog.komentar.approve');
    Route::put('/komentar/{comment}/reject', [CommentController::class, 'reject'])->name('blog.komentar.reject');
    Route::delete('/komentar/{comment}', [CommentController::class, 'destroy'])->name('blog.komentar.destroy');
    Route::post('/komentar/{id}/restore', [CommentController::class, 'restore'])->name('blog.komentar.restore');
});
