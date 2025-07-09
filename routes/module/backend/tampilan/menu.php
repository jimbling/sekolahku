<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\MenuController;

// TAMPILAN - Menu
Route::middleware(['permission:edit_menu'])->prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'aturMenu'])->name('menus.all');
    Route::get('/data', [MenuController::class, 'getMenu'])->name('menus.data');
    Route::post('/create', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/{id}/fetch', [MenuController::class, 'fetchMenuById'])->name('menus.fetch');
    Route::put('/{id}/update', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');
    Route::post('/delete-selected', [MenuController::class, 'deleteSelectedMenus'])->name('menus.delete.selected');
    Route::get('/post-pages', [MenuController::class, 'getPublishedPages']);
    Route::post('s/store-from-checkbox', [MenuController::class, 'storeFromCheckbox'])->name('menus.storeFromCheckbox');
    Route::post('s/update-order', [MenuController::class, 'updateOrder'])->name('menus.updateOrder');
});
