<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ModuleController;

Route::prefix('modules')
    ->middleware('permission:atur_modul')
    ->group(function () {
        Route::get('/', [ModuleController::class, 'index'])->name('modules.index');
        Route::post('/', [ModuleController::class, 'store'])->name('modules.store');
        Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
        Route::patch('/{module}/toggle', [ModuleController::class, 'toggle'])->name('modules.toggle');
    });
