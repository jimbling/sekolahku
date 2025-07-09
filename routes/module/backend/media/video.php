<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\VideoController;

// Media - VIDEO
Route::middleware(['permission:edit_video'])->prefix('videos')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('videos.all');
    Route::get('data', [VideoController::class, 'getVideoPosts'])->name('files.videos.data');
    Route::post('/create', [VideoController::class, 'videos_store'])->name('videos.store');
    Route::delete('/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');
    Route::post('/delete-selected', [VideoController::class, 'deleteSelectedVideos'])->name('videos.delete.selected');
    Route::get('/{id}/fetch', [VideoController::class, 'fetchVideosById'])->name('videos.fetch');
    Route::put('/{id}/update', [VideoController::class, 'update'])->name('videos.update');
});
