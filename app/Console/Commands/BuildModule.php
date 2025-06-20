<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ZipArchive;

class BuildModule extends Command
{
    protected $signature = 'module:build {name}';
    protected $description = 'Membuat file ZIP dari modul tertentu';

    public function handle()
    {
        $name = $this->argument('name');
        $modulePath = base_path("modules/{$name}");
        $zipPath = base_path("modules/{$name}.zip");

        if (!File::isDirectory($modulePath)) {
            $this->error("❌ Modul {$name} tidak ditemukan.");
            return;
        }

        // Hapus ZIP lama jika ada
        if (File::exists($zipPath)) {
            File::delete($zipPath);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($modulePath),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = $name . '/' . substr($filePath, strlen($modulePath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
            $this->info("✅ Modul {$name} berhasil dibungkus ke {$name}.zip");
        } else {
            $this->error("❌ Gagal membuat ZIP.");
        }
    }
}
