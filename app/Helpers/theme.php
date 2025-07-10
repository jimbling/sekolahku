
<?php

use App\Models\Theme;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

if (!function_exists('getActiveTheme')) {
    /**
     * Mendapatkan folder nama tema yang aktif.
     * Jika tidak ada tema aktif, kembalikan 'default'.
     *
     * @return string
     */
    function getActiveTheme(): string
    {
        // Cegah error saat migrasi awal (tabel themes belum ada)
        if (app()->runningInConsole() && !Schema::hasTable('themes')) {
            return 'default';
        }

        // Ambil tema aktif dari database
        $theme = Theme::where('is_active', 1)->first();

        return $theme ? $theme->folder_name : 'default';
    }
}

if (!function_exists('theme_view')) {
    /**
     * Membuat view berdasarkan tema aktif.
     *
     * @param string $view Nama view di dalam folder tema
     * @param array $data Data yang dilempar ke view
     * @return \Illuminate\View\View
     */
    function theme_view(string $view, array $data = [])
    {
        $theme = getActiveTheme();

        $viewPath = "themes.$theme.$view";

        // Cek apakah view sesuai tema ada
        if (!view()->exists($viewPath)) {
            $fallbackPath = "themes.default.$view";
            Log::info("theme_view fallback: view [$viewPath] tidak ditemukan, pakai [$fallbackPath]");
            $viewPath = $fallbackPath;
        } else {
            Log::info("theme_view aktif: menggunakan view [$viewPath]");
        }

        return view($viewPath, $data);
    }
}

if (!function_exists('getActiveThemeName')) {
    /**
     * Mengambil nama tema aktif (bukan nama folder), atau kembalikan 'Default' jika tidak ada.
     *
     * @return string
     */
    function getActiveThemeName(): string
    {
        if (app()->runningInConsole() && !Schema::hasTable('themes')) {
            return 'Default';
        }

        $theme = Theme::where('is_active', 1)->first();

        return $theme ? $theme->theme_name : 'Default';
    }
}
