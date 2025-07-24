<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;



Route::get('/google/auth/callback', [GoogleLoginController::class, 'handleCallback'])->name('google.auth.callback');
