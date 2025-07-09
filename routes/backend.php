<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard dasar
        Route::get('/', [\App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');


        // Modular backend loader
        foreach (glob(__DIR__ . '/module/backend/*.php') as $file) {
            require $file;
        }
    });
