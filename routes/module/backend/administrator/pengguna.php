<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;

// PENGGUNA
Route::middleware(['auth', 'verified', 'permission:atur_pengguna'])
    ->group(function () {
        Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
        Route::resource('users', UserController::class);
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });

// PROFILE
Route::middleware(['permission:edit_profile'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// HAK AKSES
Route::middleware(['permission:edit_hak_akses'])->group(function () {
    Route::get('/privilege', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('roles/update-permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');
    Route::get('/get-user-permissions/{userId}', [RoleController::class, 'getUserPermissions']);
});
