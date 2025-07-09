<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\SubscriptionController;

Route::middleware([CheckMaintenanceMode::class])->group(function () {
    Route::post('/simpan-alumni', [StudentController::class, 'storeAlumni'])->name('alumni.store');
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::get('/unsubscribe/{token}', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');
});
