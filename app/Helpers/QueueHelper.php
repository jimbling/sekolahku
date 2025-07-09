<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class QueueHelper
{
    public static function runQueueWorkerInBackground()
    {
        $env = env('QUEUE_WORKER_ENV', env('APP_ENV', 'production'));
        $artisanPath = base_path('artisan');

        if ($env === 'local') {
            $phpPath = env('QUEUE_WORKER_PHP_PATH', 'php'); // Pakai env, biar fleksibel
            $cmd = "start /B {$phpPath} {$artisanPath} queue:work --stop-when-empty";
        } else {
            $cmd = "nohup php {$artisanPath} queue:work --stop-when-empty > /dev/null 2>&1 &";
        }

        exec($cmd, $output, $returnVar);

        Log::info("Queue worker dijalankan dengan command: {$cmd}, return code: " . ($returnVar ?? 'unknown'));
        Log::info('BackupJob sedang dijalankan!');
        return ($returnVar === 0);
    }
}
