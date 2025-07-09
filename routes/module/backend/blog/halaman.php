<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PostController;

// Halaman
Route::middleware(['permission:edit_halaman'])->group(function () {
    Route::prefix('blog')->group(function () {
        // Sambutan KS
        Route::get('/sambutan', [PostController::class, 'editSambutan'])->name('edit.sambutan');
        Route::post('/sambutan', [PostController::class, 'updateSambutan'])->name('sambutan.update');

        // Pages
        Route::prefix('pages')->group(function () {
            Route::get('/', [PostController::class, 'pages'])->name('blog.pages');
            Route::get('/data', [PostController::class, 'getPages'])->name('pages.data');
            Route::get('/create', [PostController::class, 'create_pages'])->name('pages.create');
            Route::post('/simpan', [PostController::class, 'pages_store'])->name('pages.store');
            Route::get('/{id}/content', [PostController::class, 'getPostContent'])->name('pages.content');
            Route::get('/create/{id}', [PostController::class, 'editPages'])->name('pages.edit');
            Route::put('/update/{id}', [PostController::class, 'updatePages'])->name('pages.update');
            Route::delete('/{id}', [PostController::class, 'destroy'])->name('pages.destroy');
            Route::delete('/delete-selected', [PostController::class, 'deleteSelected'])->name('pages.deleteSelected');
            Route::get('/{id}/published_at', [PostController::class, 'getPublishedAt'])->name('blog.pages.published_at');
            Route::post('/update-published/{id}', [PostController::class, 'updatePublishedAt'])->name('pages.updatePublished');
        });

        // Tambahan untuk Sambutan KS
        Route::get('/sambutan', [PostController::class, 'editSambutan'])->name('edit.sambutan');
        Route::post('/sambutan', [PostController::class, 'updateSambutan'])->name('sambutan.update');
    });
});
