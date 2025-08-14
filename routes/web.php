<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/test-import', function () {
    Log::info("✅ Route import kepanggil!");
    return 'ok';
});
