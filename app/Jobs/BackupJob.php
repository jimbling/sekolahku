<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Models\Backup;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        Artisan::call('backup:run');
        $output = Artisan::output();

        if (strpos($output, 'Backup completed!') !== false) {
            $backupFiles = Storage::disk('local')->files('SinauCMS');
            $latestFile = collect($backupFiles)->sortByDesc(function ($file) {
                return Storage::disk('local')->lastModified($file);
            })->first();

            if ($latestFile) {
                Backup::updateOrCreate(
                    ['filename' => basename($latestFile)],
                    ['path' => $latestFile, 'size' => Storage::disk('local')->size($latestFile)]
                );
            }
        }
    }
}
