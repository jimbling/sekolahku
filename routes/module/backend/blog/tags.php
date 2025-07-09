<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\TagController;

Route::middleware(['permission:edit_tags'])->prefix('blog')->group(function () {
    Route::get('/tags', [TagController::class, 'index'])->name('tags.all');
    Route::get('/tag/{slug}', [TagController::class, 'showPostsByTag'])->name('tags.show');
    Route::get('/data-tags', [TagController::class, 'getTags'])->name('admin.tags.data');
    Route::post('/tags/create', [TagController::class, 'simpanTags'])->name('tags.create');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
    Route::post('/tags/delete-selected', [TagController::class, 'deleteSelectedTags'])->name('tags.delete.selected');
});
