<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Carbon;

class MakeModule extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Generate a module with backend and frontend structure';

    public function handle()
    {
        $name = $this->argument('name');
        $studlyName = Str::studly($name);     // KelulusanSiswa
        $lowerName = Str::lower($studlyName); // kelulusansiswa
        $modulePath = base_path("modules/{$studlyName}");

        if (File::exists($modulePath)) {
            $this->error("❌ Module '{$studlyName}' already exists.");
            return;
        }

        // 1. Buat struktur direktori
        File::makeDirectory($modulePath . '/Controllers', 0755, true);
        File::makeDirectory($modulePath . '/Models');
        File::makeDirectory($modulePath . '/Views/frontend', 0755, true);
        File::makeDirectory($modulePath . '/Migrations');
        File::makeDirectory($modulePath . '/Lang/en', 0755, true);

        // 2. module.json
        $moduleJson = [
            'name' => Str::headline($studlyName),
            'alias' => $studlyName,
            'version' => '1.0.0',
            'description' => "Modul untuk {$studlyName}",
            'enabled' => true,
            'prefix' => $lowerName,
            'author' => config('modules.default_author'),
            'permissions' => [
                "atur_{$lowerName}"
            ]
        ];

        File::put($modulePath . '/module.json', json_encode($moduleJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 3. Backend Controller
        File::put($modulePath . "/Controllers/{$studlyName}Controller.php", <<<PHP
<?php

namespace Modules\\{$studlyName}\\Controllers;

use Illuminate\\Http\\Request;
use Illuminate\\Routing\\Controller;

class {$studlyName}Controller extends Controller
{
    public function index()
    {
        \$judul = '{$moduleJson['name']}';
        return view('{$lowerName}::index', compact('judul'));
    }
}
PHP);

        // 4. Frontend Controller
        File::put($modulePath . "/Controllers/{$studlyName}FrontendController.php", <<<PHP
<?php

namespace Modules\\{$studlyName}\\Controllers;

use Illuminate\\Routing\\Controller;

class {$studlyName}FrontendController extends Controller
{
    public function index()
    {
        \$judul = '{$moduleJson['name']}';
        return view('{$lowerName}::frontend.index', compact('judul'));
    }
}
PHP);

        // 5. View backend
        File::put($modulePath . '/Views/index.blade.php', <<<BLADE
<x-header>{{ \$judul ?? '{$moduleJson['name']}' }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ \$judul ?? '{$moduleJson['name']}' }}</x-breadcrumb>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ \$judul }}</h3>
                        </div>
                        <div class="card-body">
                            <p>Halaman backend untuk modul {$moduleJson['name']}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<x-footer />
BLADE);

        // 6. View frontend
        File::put($modulePath . '/Views/frontend/index.blade.php', <<<BLADE
@extends('themes.' . getActiveTheme() . '.app_statis')

@section('title', strtoupper(\$judul ?? '{$moduleJson['name']}'))

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden p-5">
        <h1 class="text-2xl font-bold mb-4 uppercase">{{ \$judul ?? '{$moduleJson['name']}' }}</h1>

        <p>Halaman frontend untuk modul {$moduleJson['name']}.</p>
    </div>
</div>
@endsection
BLADE);


        // 7. View menu.blade.php
        File::put($modulePath . '/Views/menu.blade.php', <<<BLADE
@can('atur_modul')
<li class="nav-item">
    <a href="{{ route('{$lowerName}.index') }}" class="nav-link {{ request()->is('admin/{$lowerName}*') ? 'active' : '' }}">
        <i class="fas fa-cube nav-icon"></i>
        <p>{{ __('{$moduleJson['name']}') }}</p>
    </a>
</li>
@endcan
BLADE);

        // 8. routes.php
        File::makeDirectory($modulePath . '/routes');
        File::put($modulePath . '/routes/web.php', <<<PHP
<?php

use Illuminate\\Support\\Facades\\Route;
use Modules\\{$studlyName}\\Controllers\\{$studlyName}FrontendController;

// 🔒 Middleware untuk memastikan modul aktif
Route::middleware(['module.active:{$studlyName}'])->group(function () {
    Route::get('/', [{$studlyName}FrontendController::class, 'index'])->name('{$lowerName}.public.index');
});
PHP);


        File::put($modulePath . '/routes/admin.php', <<<PHP
<?php

use Illuminate\\Support\\Facades\\Route;
use Modules\\{$studlyName}\\Controllers\\{$studlyName}Controller;

// 🔐 Middleware: web, auth, permission, dan modul aktif
Route::middleware(['web', 'auth', 'permission:atur_{$lowerName}', 'module.active:{$studlyName}'])
      ->group(function () {
        Route::get('/', [{$studlyName}Controller::class, 'index'])->name('{$lowerName}.index');
    });
PHP);



        // 9. Sample Migration
        $migrationName = 'create_' . $lowerName . '_table';
        $migrationClass = 'Create' . Str::studly($lowerName) . 'Table';
        $migrationFile = now()->format('Y_m_d_His') . "_{$migrationName}.php";

        File::put($modulePath . "/Migrations/{$migrationFile}", <<<PHP
<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{$lowerName}', function (Blueprint \$table) {
            \$table->id();
            \$table->string('nama');
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{$lowerName}');
    }
};
PHP);

        // 10. Sample Model
        File::put($modulePath . "/Models/{$studlyName}.php", <<<PHP
<?php

namespace Modules\\{$studlyName}\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class {$studlyName} extends Model
{
    protected \$table = '{$lowerName}';

    protected \$fillable = ['nama']; // sesuaikan dengan kolom migrasi
}
PHP);


        // 1. Menjalankan migrasi
        $this->info("📦 Menjalankan migrasi modul...");

        $migrationPath = "modules/{$studlyName}/Migrations";
        $fullMigrationPath = base_path($migrationPath);

        if (File::isDirectory($fullMigrationPath)) {
            Artisan::call('migrate', [
                '--path' => $migrationPath,
                '--force' => true
            ]);

            $this->line(Artisan::output());

            // Validasi tabel berhasil dibuat (jika tahu nama tabel pasti)
            if (Schema::hasTable($lowerName)) {
                $this->info("✅ Tabel '{$lowerName}' berhasil dibuat.");
            } else {
                $this->warn("⚠️ Tabel '{$lowerName}' belum terdeteksi atau belum dibuat.");
            }
        } else {
            $this->warn("⚠️ Folder migrasi tidak ditemukan: {$migrationPath}");
        }

        // 2. Menambahkan permission ke DB dan helper
        $this->info("🔐 Menambahkan permission...");

        foreach ($moduleJson['permissions'] as $perm) {
            // Simpan ke DB
            DB::table('permissions')->updateOrInsert(
                ['name' => $perm],
                [
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            // Update helper
            register_permission_label($perm, $moduleJson['name']);
        }

        $this->info("✅ Permission berhasil ditambahkan ke DB & helper.");

        // 🔁 Reset cache permission Spatie
        Artisan::call('permission:cache-reset');
        $this->line(Artisan::output());

        // 3. Sinkronkan modul ke tabel `modules`
        $this->info("🔄 Menyinkronkan modul ke database...");
        Artisan::call('app:modules-sync');
        $this->line(Artisan::output());

        // 4. Final message
        $this->info("✅ Module {$studlyName} berhasil dibuat dengan struktur lengkap (backend + frontend).");
    }
}
