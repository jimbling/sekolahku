<?php

namespace App\Services\Backend\Tampilan;

use App\Models\Theme;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class ThemeUploadService
{
    protected $destination;

    public function __construct()
    {
        $this->destination = resource_path('views/themes');
    }

    public function uploadAndExtract($request): array
    {
        $zip = $request->file('theme_file');
        $themeName = $request->theme_name;
        $extractPath = $this->destination . '/' . $themeName;

        // Buat folder tujuan jika belum ada
        if (!File::exists($this->destination)) {
            File::makeDirectory($this->destination, 0755, true);
        }

        // Cek folder fisik
        if (File::exists($extractPath)) {
            throw new \Exception("Folder tema dengan nama '$themeName' sudah ada di direktori themes.");
        }

        // Cek database
        if (Theme::where('theme_name', $themeName)->orWhere('folder_name', $themeName)->exists()) {
            throw new \Exception("Tema dengan nama atau folder '$themeName' sudah terdaftar di database.");
        }

        // Simpan zip sementara
        $zipPath = storage_path('app/temp_theme.zip');
        $zip->move(storage_path('app'), 'temp_theme.zip');

        $zipArchive = new ZipArchive;
        if ($zipArchive->open($zipPath) === TRUE) {
            $zipArchive->extractTo($extractPath);
            $zipArchive->close();
            unlink($zipPath); // Hapus file zip sementara

            // Jalankan artisan command: theme:link-assets
            try {
                Artisan::call('theme:link-assets');
                Log::info('Berhasil menjalankan perintah theme:link-assets.', [
                    'output' => Artisan::output()
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menjalankan perintah theme:link-assets.', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            return [
                'theme_name'    => $themeName,
                'display_name'  => $request->display_name,
                'description'   => $request->description,
                'folder_name'   => $themeName,
            ];
        }

        throw new \Exception("Gagal mengekstrak file tema.");
    }
}
