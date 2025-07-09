<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot(): void
    {
        parent::boot();

        // Auth (login/logout/register dsb)
        Route::middleware('web')
            ->group(base_path('routes/auth.php'));

        // Global routes
        $this->loadRouteFilesFrom('routes/global');

        // Frontend (tanpa auth)
        $this->loadRouteFilesFrom('routes/module/frontend');

        // Backend (with auth & admin prefix)
        Route::middleware(['web', 'auth', 'verified'])
            ->prefix('admin')
            ->name('admin.')
            ->group(function () {
                $this->loadRouteFilesFrom('routes/module/backend');
            });

        // Patch route legacy
        if (is_dir(base_path('routes_patch'))) {
            $this->loadRouteFilesFrom('routes_patch');
        }

        // Tetap support web.php manual
        $this->loadRouteFilesFrom('routes/web.php');
    }


    /**
     * Load all route files (recursively if directory).
     */
    protected function loadRouteFilesFrom(string $path): void
    {
        $fullPath = base_path($path);

        if (is_file($fullPath)) {
            Route::group([], $fullPath);
        } elseif (is_dir($fullPath)) {
            foreach ($this->getPhpFiles($fullPath) as $file) {
                Route::group([], $file);
            }
        }
    }

    /**
     * Get all PHP files recursively in a directory.
     */
    protected function getPhpFiles(string $dir): array
    {
        return collect(glob($dir . '/**/*.php'))
            ->merge(glob($dir . '/*.php'))
            ->filter(fn($file) => is_file($file))
            ->toArray();
    }
}
