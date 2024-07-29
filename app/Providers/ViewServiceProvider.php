<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;



class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // PERMISSION MENU VIEW BLOG
        View::composer('*', function ($view) {
            $user = Auth::user();
            if ($user) {
                $hasEditPosts = $user->can('edit_posts');
                $hasEditCategories = $user->can('edit_categories');
                $hasEditTags = $user->can('edit_tags');
                $hasEditKutipan = $user->can('edit_kutipan');
                $hasEditTautan = $user->can('edit_tautan');

                $view->with('canViewBlogMenu', $hasEditPosts || $hasEditCategories || $hasEditTags || $hasEditKutipan || $hasEditTautan);
            } else {
                $view->with('canViewBlogMenu', false);
            }
        });


        // PERMISSION MENU PENGGUNA
        View::composer('*', function ($view) {
            $user = Auth::user();
            if ($user) {
                $hasEditProfile = $user->can('edit_profile');
                $hasEditHakAkses = $user->can('edit_hak_akses');

                $view->with('canViewUserMenu', $hasEditProfile || $hasEditHakAkses);
            } else {
                $view->with('canViewUserMenu', false);
            }
        });

        // PERMISSION MENU MEDIA
        View::composer('*', function ($view) {
            $user = Auth::user();
            if ($user) {
                $hasEditFile = $user->can('edit_file');
                $hasEditVideo = $user->can('edit_video');

                $view->with('canViewMediaMenu', $hasEditFile || $hasEditVideo);
            } else {
                $view->with('canViewMediaMenu', false);
            }
        });

        // PERMISSION MENU AKADEMIK
        View::composer('*', function ($view) {
            $user = Auth::user();
            if ($user) {
                $hasEditRombel = $user->can('edit_rombel');
                $hasEditPd = $user->can('edit_pd');
                $hasEditTahunPelajaran = $user->can('edit_tahun_pelajaran');
                $hasEditKelas = $user->can('edit_kelas');

                $view->with('canViewAkademikMenu', $hasEditRombel || $hasEditPd || $hasEditTahunPelajaran || $hasEditKelas);
            } else {
                $view->with('canViewAkademikMenu', false);
            }
        });
    }
}
