<?php

namespace App\Http\Controllers\Backend;

use ZipArchive;
use App\Models\Patch;
use App\Models\School;
use App\Models\AppVersion;
use Illuminate\Http\Request;
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

        $extractTo = base_path("modules/{$patchFolder}");

        if (!File::exists($extractTo)) {
            File::makeDirectory($extractTo, 0755, true);
        }

        $path = storage_path("app/patches/{$filename}");
        $file->move(storage_path('app/patches'), $filename);

        $zip = new \ZipArchive;
        if ($zip->open($path) === true) {
            $zip->extractTo($extractTo);
            $zip->close();
        } else {
            return back()->with('error', 'Gagal mengekstrak file patch.');
        }

        // Baca patch.json
        $metaFile = $extractTo . '/patch.json';
        if (!file_exists($metaFile)) {
            return back()->with('error', 'File patch.json tidak ditemukan.');
        }

        $meta = json_decode(file_get_contents($metaFile), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->with('error', 'File patch.json tidak valid.');
        }

        $version = $meta['version'] ?? null;
        $name = $meta['name'] ?? 'Patch Tanpa Nama';
        $description = $meta['description'] ?? '-';

        if (!$version) {
            return back()->with('error', 'Versi patch tidak ditemukan di patch.json.');
        }

        if (\App\Models\Patch::where('version', $version)->exists()) {
            return back()->with('error', 'Patch versi ini sudah pernah di-install.');
        }

        // Jalankan migrasi jika ada
        if (File::isDirectory($extractTo . '/Migrations')) {
            \Artisan::call('migrate', [
                '--path' => "modules/{$patchFolder}/Migrations",
                '--force' => true,
            ]);
        }

        // Jalankan script.php jika ada
        if (file_exists($extractTo . '/script.php')) {
            include $extractTo . '/script.php';
        }

        // Salin file sesuai instruksi
        if (!isset($meta['files']) || !is_array($meta['files'])) {
            return back()->with('error', 'Struktur patch.json tidak memiliki instruksi file.');
        }

        $publicPath = env('APP_PUBLIC_PATH', public_path());

        foreach ($meta['files'] as $file) {
            $source = $extractTo . '/' . ltrim($file['source'], '/');

            $target = str_starts_with($file['target'], 'public/')
                ? $publicPath . '/' . substr($file['target'], 7)
                : base_path($file['target']);

            if (!File::exists($source)) {
                return back()->with('error', "File source tidak ditemukan: {$file['source']}");
            }

            File::ensureDirectoryExists(dirname($target));
            File::copy($source, $target);
        }

        // Simpan ke DB
        \App\Models\Patch::create([
            'name' => $name,
            'version' => $version,
            'description' => $description,
            'installed_at' => now(),
        ]);

        \App\Models\AppVersion::create([
            'version' => $version,
            'changelog' => $description,
            'applied_at' => now(),
        ]);

        return back()->with('success', 'Patch berhasil di-install dan file berhasil disalin.');
    }
}
