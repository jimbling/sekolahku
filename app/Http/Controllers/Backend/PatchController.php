<?php

namespace App\Http\Controllers\Backend;

use ZipArchive;
use App\Models\Patch;
use App\Models\School;
use App\Models\AppVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

class PatchController extends Controller
{
    public function index()
    {
        $judul = 'Manajemen Patch Sistem';

        $school = School::first();
        $isRegistered = $school && $school->license_key && ($school->license_status  ?? 'inactive') === 'active';

        $versi = AppVersion::orderByDesc('applied_at')->first();
        $riwayat = Patch::orderByDesc('installed_at')->get();

        return view('admin.pemeliharaan.patch-update', compact('judul', 'school', 'isRegistered', 'versi', 'riwayat'));
    }

    public function checkForUpdate()
    {
        $school = School::first();

        if (! $school || ! $school->license_key) {
            return response()->json(['error' => 'Token tidak ditemukan.'], 400);
        }

        $currentVersion = AppVersion::orderByDesc('applied_at')->first()?->version ?? '1.0.0';

        $response = Http::post('https://sinaucms.web.id/api/patch/check', [
            'token' => $school->license_key,
            'current_version' => $currentVersion,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal menghubungi server update.'], 500);
        }

        $data = $response->json();

        if ($data['update_available']) {
            return response()->json([
                'message' => 'Update tersedia',
                'updateInfo' => $data['patch']
            ]);
        }

        return response()->json(['message' => 'Tidak ada update tersedia.']);
    }


    public function upload(Request $request)
    {
        $request->validate([
            'patch_file' => 'required|file|mimes:zip|max:51200', // Maks. 50MB
        ]);

        $file = $request->file('patch_file');
        $filename = $file->getClientOriginalName();
        $patchFolder = pathinfo($filename, PATHINFO_FILENAME);

        $tmpExtractPath = storage_path("app/patches/tmp/{$patchFolder}");

        File::ensureDirectoryExists($tmpExtractPath);

        $storedZipPath = storage_path("app/patches/{$filename}");
        $file->move(storage_path('app/patches'), $filename);

        $zip = new \ZipArchive;
        if ($zip->open($storedZipPath) === true) {
            $zip->extractTo($tmpExtractPath);
            $zip->close();
        } else {
            return back()->with('error', 'Gagal mengekstrak file patch.');
        }

        $metaFile = $tmpExtractPath . '/patch.json';
        if (!file_exists($metaFile)) {
            File::deleteDirectory($tmpExtractPath);
            return back()->with('error', 'File patch.json tidak ditemukan.');
        }

        $meta = json_decode(file_get_contents($metaFile), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            File::deleteDirectory($tmpExtractPath);
            return back()->with('error', 'File patch.json tidak valid.');
        }

        $version = $meta['version'] ?? null;
        $name = $meta['name'] ?? 'Patch Tanpa Nama';
        $description = $meta['description'] ?? '-';
        $type = $meta['type'] ?? 'patch';

        if (!$version) {
            File::deleteDirectory($tmpExtractPath);
            return back()->with('error', 'Versi patch tidak ditemukan di patch.json.');
        }

        if (Patch::where('version', $version)->exists()) {
            File::deleteDirectory($tmpExtractPath);
            return back()->with('error', 'Patch versi ini sudah pernah di-install.');
        }

        // Cek & log file migrasi
        $migrationsPath = "{$tmpExtractPath}/Migrations";
        if (!File::exists($migrationsPath)) {
            Log::error("❌ Folder migrasi tidak ditemukan: " . $migrationsPath);
        } else {
            Log::info("📂 Daftar file di folder migrasi:");
            foreach (File::files($migrationsPath) as $file) {
                Log::info(" - " . $file->getFilename());

                // Coba include untuk validasi PHP-nya terbaca
                try {
                    include_once $file->getRealPath();
                } catch (\Throwable $e) {
                    Log::error("❌ Error saat include file migrasi: " . $file->getFilename());
                    Log::error($e->getMessage());
                }
            }
        }

        // Jalankan migrasi
        Log::info("🚀 Menjalankan migrasi dari path: {$migrationsPath}");
        Artisan::call('migrate', [
            '--path' => $migrationsPath,
            '--realpath' => true,
            '--force' => true,
        ]);
        Log::info(" Output migrasi: " . Artisan::output());

        // Jalankan script.php
        if (file_exists($tmpExtractPath . '/script.php')) {
            include $tmpExtractPath . '/script.php';
        }

        // Salin file
        if (isset($meta['files']) && is_array($meta['files'])) {
            $publicPath = env('APP_PUBLIC_PATH', public_path());

            foreach ($meta['files'] as $fileInstruction) {
                $source = $tmpExtractPath . '/' . ltrim($fileInstruction['source'], '/');

                if (str_starts_with($fileInstruction['target'], 'public/')) {
                    $target = $publicPath . '/' . substr($fileInstruction['target'], 7);
                } elseif (str_starts_with($fileInstruction['target'], 'routes_patch/')) {
                    $target = base_path('routes_patch/' . substr($fileInstruction['target'], 13));
                } else {
                    $target = base_path($fileInstruction['target']);
                }

                if (!File::exists($source)) {
                    File::deleteDirectory($tmpExtractPath);
                    return back()->with('error', "File source tidak ditemukan: {$fileInstruction['source']}");
                }

                File::ensureDirectoryExists(dirname($target));
                File::copy($source, $target);
            }
        }

        // Jika module, pindah ke folder modules


        Patch::create([
            'name' => $name,
            'version' => $version,
            'description' => $description,
            'installed_at' => now(),
        ]);

        AppVersion::create([
            'version' => $version,
            'changelog' => $description,
            'applied_at' => now(),
        ]);

        return back()->with('success', 'Patch berhasil di-install.');
    }
}
