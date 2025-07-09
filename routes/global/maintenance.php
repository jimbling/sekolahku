<?php

use Illuminate\Support\Facades\Route;

Route::get('/perawatan', fn() => view('maintenance'))->name('maintenance');
