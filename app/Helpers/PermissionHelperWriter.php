<?php

use Illuminate\Support\Str;

if (!function_exists('register_permission_label')) {
    function register_permission_label(string $permissionName, string $friendlyName): void
    {
        $helperPath = app_path('Helpers/PermissionHelper.php');

        if (!file_exists($helperPath)) {
            return;
        }

        $contents = file_get_contents($helperPath);

        $pattern = '/\\$mapping\\s+=\\s+\\[(.*?)\\];/s';
        if (preg_match($pattern, $contents, $matches)) {
            $existing = trim($matches[1]);

            if (strpos($existing, "'{$permissionName}'") !== false) {
                return;
            }

            $friendlyName = Str::headline($friendlyName);
            $newEntry = "        '{$permissionName}' => '{$friendlyName}',\n";

            $updated = str_replace(
                $matches[0],
                "\$mapping = [\n{$newEntry}{$existing}\n    ];",
                $contents
            );

            file_put_contents($helperPath, $updated);
        }
    }
}

if (!function_exists('unregister_permission_label')) {
    function unregister_permission_label(string $permissionName): void
    {
        $helperPath = app_path('Helpers/PermissionHelper.php');

        if (!file_exists($helperPath)) {
            return;
        }

        $contents = file_get_contents($helperPath);

        // Regex untuk mencari dan menghapus baris yang sesuai
        $pattern = "/\s*'{$permissionName}'\s*=>\s*'.*?',?\n/";

        $updated = preg_replace($pattern, '', $contents);

        file_put_contents($helperPath, $updated);
    }
}
