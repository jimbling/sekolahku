<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ApplyPatch extends Command
{
    protected $signature = 'patch:apply {folder}';
    protected $description = 'Terapkan patch update ke sistem Laravel';

    public function handle()
    {
        $folder = $this->argument('folder');
        $patchPath = base_path("patches/{$folder}");
        $manifest = "{$patchPath}/patch.json";

        if (!File::exists($manifest)) {
            $this->error("❌ patch.json tidak ditemukan di {$folder}.");
            return;
        }

        $json = json_decode(File::get($manifest), true);
        $this->info("🚀 Menerapkan patch: {$json['name']} (versi: {$json['version']})");

        foreach ($json['files'] as $relativePath) {
            $from = "{$patchPath}/{$relativePath}";

            $target = str($relativePath)->startsWith('public/')
                ? base_path("../public_html/" . str($relativePath)->after('public/'))
                : base_path($relativePath);

            File::ensureDirectoryExists(dirname($target));

            // Opsional: backup sebelum timpa
            if (File::exists($target)) {
                File::copy($target, $target . '.bak');
                $this->warn("📦 Backup dibuat: {$target}.bak");
            }

            File::copy($from, $target);
            $this->info("✔ Disalin: {$relativePath}");
        }

        $json['applied_at'] = now()->toDateTimeString();
        File::put($manifest, json_encode($json, JSON_PRETTY_PRINT));
        $this->info(" Patch berhasil diterapkan.");
    }
}
