<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\FilesController;

// Media - FILE
Route::middleware(['permission:edit_file'])->prefix('files')->group(function () {
    Route::get('/all', [FilesController::class, 'index'])->name('files.all');
    Route::get('/data', [FilesController::class, 'getFiles'])->name('files.data');
    Route::post('/create', [FilesController::class, 'store'])->name('files.store');
    Route::delete('/{id}', [FilesController::class, 'destroy'])->name('files.destroy');
    Route::post('/delete-selected', [FilesController::class, 'deleteSelectedFiles'])->name('files.delete.selected');
    Route::get('/{id}/fetch', [FilesController::class, 'fetchFilesById'])->name('files.fetch');
    Route::put('/{id}/update', [FilesController::class, 'update'])->name('files.update');
});
