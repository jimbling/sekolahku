<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\GtkController;
// GTK
Route::middleware(['permission:edit_gtk'])->prefix('gtk')->group(function () {
    Route::get('/all', [GtkController::class, 'index'])->name('gtk.all');
    Route::get('/data', [GtkController::class, 'getGtk'])->name('gtk.data');
    Route::delete('/{id}', [GtkController::class, 'destroy'])->name('gtk.destroy');
    Route::post('/delete-selected', [GtkController::class, 'deleteSelectedGtks'])->name('gtk.delete.selected');
    Route::post('/create', [GtkController::class, 'store'])->name('gtk.store');
    Route::get('/{id}/fetch', [GtkController::class, 'fetchGtkById'])->name('gtk.fetch');
    Route::put('/{id}/update', [GtkController::class, 'update'])->name('gtk.update');
});
