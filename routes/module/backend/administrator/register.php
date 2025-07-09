<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SchoolRegistrationController;

Route::middleware(['auth'])->group(function () {
    Route::get('/register-school', [SchoolRegistrationController::class, 'showForm'])->name('school.register');
    Route::post('/register-school/verify', [SchoolRegistrationController::class, 'verifyToken'])->name('school.verify');
    Route::post('/register-school/store', [SchoolRegistrationController::class, 'store'])->name('school.store');
});
