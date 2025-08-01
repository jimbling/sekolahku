<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ModulesSync extends Command
{
    protected $signature = 'app:modules-sync';
    protected $description = 'Sync all module.json into the modules table';

    public function handle()
    {
        $modulesPath = base_path('modules');
        $modules = File::directories($modulesPath);
        $synced = 0;

        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);
            $configPath = $modulePath . '/module.json';

            if (!File::exists($configPath)) {
                $this->warn("⚠️ module.json not found for: {$moduleName}");
                continue;
            }

            $config = json_decode(file_get_contents($configPath), true);
            if (!($config['alias'] ?? null)) {
                $this->warn("⚠️ module.json missing alias: {$moduleName}");
                continue;
            }

            DB::table('modules')->updateOrInsert(
                ['alias' => $config['alias']],
                [
                    'name' => $config['name'] ?? $moduleName,
                    'version' => $config['version'] ?? '1.0.0',
                    'description' => $config['description'] ?? '',
                    'prefix' => $config['prefix'] ?? strtolower($moduleName),
                    'enabled' => $config['enabled'] ?? false,
                    'permissions' => json_encode($config['permissions'] ?? []),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $this->info(" Synced module: {$config['alias']}");
            $synced++;
        }

        $this->info("🎯 Total modules synced: {$synced}");
    }
}
