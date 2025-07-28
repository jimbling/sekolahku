<?php

use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;



Route::get('/google/auth/callback', [GoogleLoginController::class, 'handleCallback'])->name('google.auth.callback');
// routes/web.php
Route::middleware(['web', 'auth'])->post('/google/disconnect', [GoogleController::class, 'disconnect'])
    ->name('google.disconnect');
