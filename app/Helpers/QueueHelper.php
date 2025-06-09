<?php

namespace App\Helpers;

use Log;

class QueueHelper
{
    public static function runQueueWorkerInBackground()
    {
        $env = env('QUEUE_WORKER_ENV', env('APP_ENV', 'production'));
        $artisanPath = base_path('artisan');

        if ($env === 'local') {
            // contoh path php di Windows Laragon, sesuaikan kalau beda
            $phpPath = 'F:\laragon\bin\php\php-8.3.7-Win32-vs16-x64\php.exe';
            $cmd = "\"{$phpPath}\" {$artisanPath} queue:work --once > NUL 2>&1 &";
        } else {
            // default asumsikan shared hosting Linux
            $cmd = "nohup php {$artisanPath} queue:work --once > /dev/null 2>&1 &";
        }

        exec($cmd, $output, $returnVar);

        Log::info("Queue worker dijalankan dengan command: {$cmd}, return code: " . ($returnVar ?? 'unknown'));

        return ($returnVar === 0);
    }
}
