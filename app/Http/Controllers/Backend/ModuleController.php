<?php

namespace App\Http\Controllers\Backend;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{
    public function index()
    {
        $judul = 'Manajemen Modul';
        $modules = Module::all();
        return view('admin.modules.index', compact('judul', 'modules'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'module_zip' => 'required|mimes:zip|max:5120' // max 5MB
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $zip = $request->file('module_zip');
            $filename = $zip->getClientOriginalName();
            $tempPath = storage_path('app/temp_modules');

            if (!File::exists($tempPath)) {
                File::makeDirectory($tempPath);
                Log::info("📁 Membuat folder sementara: {$tempPath}");
            }

            $zip->move($tempPath, $filename);
            Log::info("📦 File ZIP diunggah: {$zip->getClientOriginalName()} ke {$tempPath}");

            $zipPath = $tempPath . '/' . $filename;

            $zipArchive = new \ZipArchive;
            if ($zipArchive->open($zipPath) === TRUE) {
                $moduleName = str_replace('.zip', '', $filename);
                $extractPath = base_path('modules/' . $moduleName);

                if (File::exists($extractPath)) {
                    Log::warning("⚠️ Modul '{$moduleName}' sudah ada.");
                    return response()->json([
                        'success' => false,
                        'message' => "Modul '{$moduleName}' sudah ada.",
                    ], 400);
                }

                $zipArchive->extractTo($extractPath);
                $zipArchive->close();

                Log::info("📂 Modul diekstrak ke: {$extractPath}");
            } else {
                Log::error("❌ Gagal membuka file ZIP: {$zipPath}");
                return response()->json([
                    'success' => false,
                    'message' => "Gagal mengekstrak ZIP.",
                ], 400);
            }



            // Baca module.json
            $jsonPath = $extractPath . '/module.json';
            if (!file_exists($jsonPath)) {
                // Cek jika module.json ada di dalam subfolder
                $nested = glob($extractPath . '/*/module.json');
                if (!empty($nested)) {
                    Log::error("❌ module.json berada di subfolder: {$nested[0]}");
                } else {
                    Log::error("❌ File module.json tidak ditemukan: {$jsonPath}");
                }

                File::deleteDirectory($extractPath);
                return response()->json([
                    'success' => false,
                    'message' => "module.json tidak ditemukan atau berada di struktur yang salah.",
                ], 400);
            }



            $json = json_decode(file_get_contents($jsonPath), true);
            if (!$json || !isset($json['name'])) {
                Log::error("❌ module.json tidak valid. Isi: " . file_get_contents($jsonPath));
                File::deleteDirectory($extractPath);
                return response()->json([
                    'success' => false,
                    'message' => "module.json tidak valid. Pastikan berisi key 'name'.",
                ], 400);
            }

            if (!isset($json['alias']) || !is_string($json['alias'])) {
                Log::error("❌ Alias tidak ditemukan atau bukan string di module.json");
                File::deleteDirectory($extractPath);
                return response()->json([
                    'success' => false,
                    'message' => "Alias tidak ditemukan di module.json.",
                ], 400);
            }

            // Tambahkan validasi karakter alias di sini
            $alias = strtolower($json['alias']);
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $alias)) {
                Log::error("❌ Alias '{$alias}' mengandung karakter tidak valid.");
                File::deleteDirectory($extractPath);
                File::delete($zipPath);
                return response()->json([
                    'success' => false,
                    'message' => "Alias hanya boleh mengandung huruf, angka, dan underscore.",
                ], 400);
            }

            // Cek jika alias sudah ada
            if (\App\Models\Module::where('alias', $alias)->exists()) {
                Log::warning("⚠️ Alias '{$alias}' sudah ada di database.");
                File::deleteDirectory($extractPath);
                return response()->json([
                    'success' => false,
                    'message' => "Alias '{$alias}' sudah ada. Gunakan alias unik.",
                ], 422);
            }


            // Simpan ke DB
            \App\Models\Module::updateOrCreate(
                ['alias' => $alias],
                [
                    'name' => $json['name'],
                    'version' => $json['version'] ?? '1.0.0',
                    'description' => $json['description'] ?? '',
                    'enabled' => $json['enabled'] ?? true,
                    'prefix' => $json['prefix'] ?? $alias,
                    'author' => $json['author'] ?? null,
                    'permissions' => json_encode($json['permissions'] ?? []),
                ]
            );


            Log::info("✅ Modul '{$json['name']}' berhasil disimpan ke database.");

            // Tambah permission
            if (!is_array($json['permissions'] ?? null)) {
                Log::warning("⚠️ Permissions di module.json bukan array.");
                return response()->json([
                    'success' => false,
                    'message' => "Format permissions di module.json tidak valid (harus array).",
                ], 400);
            }
            foreach ($json['permissions'] ?? [] as $perm) {
                DB::table('permissions')->updateOrInsert(
                    ['name' => $perm],
                    ['guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()]
                );
                register_permission_label($perm, $json['name']);

                Log::info("🔐 Permission '{$perm}' ditambahkan & disinkronkan ke helper.");
            }

            // Reset permission cache dan sync modul
            Artisan::call('permission:cache-reset');
            Artisan::call('app:modules-sync');

            Log::info("✅ Artisan permission cache di-reset dan modul disinkronkan.");
            // Hapus file ZIP setelah selesai
            File::delete($zipPath);

            return response()->json([
                'success' => true,
                'message' => "Modul {$json['name']} berhasil diinstal."
            ]);
        } catch (\Exception $e) {
            if (isset($zipPath) && File::exists($zipPath)) {
                File::delete($zipPath);
            }

            Log::error("❌ Terjadi error saat instalasi modul: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat instalasi modul.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Module $module)
    {
        try {
            $moduleName = $module->name;
            $alias = $module->alias;
            $modulePath = base_path("modules/{$alias}");

            // 1. Jalankan rollback migration (jika ada)
            $migrationPath = $modulePath . '/Migrations';
            if (File::exists($migrationPath)) {
                Artisan::call('migrate:rollback', [
                    '--path' => str_replace(base_path() . '/', '', $migrationPath),
                    '--force' => true
                ]);
                Log::info("🔁 Rollback migration untuk modul {$alias} berhasil.");
            }

            // 2. Hapus permissions dari DB & helper
            $jsonPath = $modulePath . '/module.json';
            if (File::exists($jsonPath)) {
                $json = json_decode(file_get_contents($jsonPath), true);
                if (is_array($json['permissions'] ?? null)) {
                    foreach ($json['permissions'] as $perm) {
                        DB::table('permissions')->where('name', $perm)->delete();
                        unregister_permission_label($perm); // jika kamu buat fungsi ini
                        Log::info("🗑️ Permission '{$perm}' dihapus.");
                    }
                }
            }

            // 3. Hapus folder modul
            if (File::exists($modulePath)) {
                File::deleteDirectory($modulePath);
                Log::info("🗑️ Folder modul '{$alias}' dihapus dari direktori.");
            }

            // 4. Hapus entri modul di DB
            $module->delete();
            Log::info("✅ Modul '{$moduleName}' berhasil dihapus dari database.");

            // 5. Reset cache & sinkronisasi ulang
            Artisan::call('permission:cache-reset');
            Artisan::call('app:modules-sync');

            return response()->json([
                'success' => true,
                'message' => "Modul '{$moduleName}' berhasil dihapus."
            ]);
        } catch (\Exception $e) {
            Log::error("❌ Gagal menghapus modul '{$module->alias}': " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus modul: ' . $e->getMessage()
            ], 500);
        }
    }


    public function toggle(Module $module)
    {
        try {
            $module->enabled = !$module->enabled;
            $module->save();

            return response()->json([
                'success' => true,
                'message' => 'Status modul berhasil diubah.',
                'enabled' => $module->enabled
            ]);
        } catch (\Exception $e) {
            Log::error("Error toggling module status: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status modul: ' . $e->getMessage()
            ], 500);
        }
    }
}
