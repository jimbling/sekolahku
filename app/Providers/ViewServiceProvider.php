<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();

            // Ambil daftar permission hanya jika login
            $permissions = $user ? $user->getAllPermissions()->pluck('name')->toArray() : [];

            // Permission Flags
            $view->with([
                'canViewBlogMenu'      => $this->hasAny($permissions, ['edit_posts', 'edit_categories', 'edit_tags', 'edit_kutipan', 'edit_tautan']),
                'canViewUserMenu'      => $this->hasAny($permissions, ['edit_profile', 'edit_hak_akses', 'atur_pengguna']),
                'canViewMediaMenu'     => $this->hasAny($permissions, ['edit_file', 'edit_video', 'edit_photo']),
                'canViewAkademikMenu'  => $this->hasAny($permissions, ['edit_rombel', 'edit_pd', 'edit_tahun_pelajaran', 'edit_kelas', 'edit_gtk']),
                'canViewPublikasiMenu' => in_array('atur_publikasi', $permissions),
                'canEditMenu'          => in_array('edit_menu', $permissions),
                'canEditPengaturan'    => in_array('edit_pengaturan', $permissions),
                'canEditPemeliharaan'  => in_array('edit_pemeliharaan', $permissions),

            ]);

            // Static menus from config
            $view->with('menus', config('menu'));
        });
    }

    /**
     * Helper to check any of the permissions exist
     */
    private function hasAny(array $permissions, array $required): bool
    {
        return !empty(array_intersect($permissions, $required));
    }
}
