<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LinkThemeAssets extends Command
{
    protected $signature = 'theme:link-assets';
    protected $description = 'Buat symlink otomatis dari resources/themes ke public/themes';

    public function handle()
    {
        $resourceThemesPath = resource_path('views/themes');
        $publicThemesPath = public_path('themes');

        if (!File::exists($resourceThemesPath)) {
            $this->error("Folder themes di resources tidak ditemukan: {$resourceThemesPath}");
            return 1;
        }

        // Pastikan folder public/themes ada
        if (!File::exists($publicThemesPath)) {
            File::makeDirectory($publicThemesPath, 0755, true);
            $this->info("Membuat folder public/themes");
        }

        // Dapatkan semua folder tema di resources/themes
        $themes = File::directories($resourceThemesPath);

        foreach ($themes as $themePath) {
            $themeName = basename($themePath);
            $source = $resourceThemesPath . DIRECTORY_SEPARATOR . $themeName . DIRECTORY_SEPARATOR . 'assets';
            $link = $publicThemesPath . DIRECTORY_SEPARATOR . $themeName . DIRECTORY_SEPARATOR . 'assets';

            if (!File::exists($source)) {
                $this->warn("Folder assets tidak ditemukan untuk tema {$themeName}, dilewati.");
                continue;
            }

            // Pastikan folder tema di public ada
            $publicThemeFolder = $publicThemesPath . DIRECTORY_SEPARATOR . $themeName;
            if (!File::exists($publicThemeFolder)) {
                File::makeDirectory($publicThemeFolder, 0755, true);
                $this->info("Membuat folder public/themes/{$themeName}");
            }

            if (File::exists($link)) {
                $this->info("Symlink sudah ada untuk tema {$themeName}, menghapus dulu...");
                File::delete($link); // hapus symlink lama
            }

            // Buat symlink
            if (symlink($source, $link)) {
                $this->info("Symlink berhasil dibuat untuk tema {$themeName}");
            } else {
                $this->error("Gagal membuat symlink untuk tema {$themeName}");
            }
        }

        return 0;
    }
}
