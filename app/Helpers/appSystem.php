<?php

use App\Models\AppVersion;

if (!function_exists('currentAppVersion')) {
    function currentAppVersion(): ?AppVersion
    {
        return AppVersion::orderByDesc('applied_at')->first();
    }
}
