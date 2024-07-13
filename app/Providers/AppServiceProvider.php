<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\Message;

class AppServiceProvider extends ServiceProvider
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
        // Logika sebelumnya
        view()->composer('*', function ($view) {
            $view->with('currentYear', Carbon::now()->year);
        });

        // Logika baru untuk notifikasi pesan
        view()->composer('*', function ($view) {
            $unreadMessagesCount = Message::where('is_read', false)->count();
            $unreadMessages = Message::where('is_read', false)->orderBy('created_at', 'desc')->take(5)->get();
            $view->with(compact('unreadMessagesCount', 'unreadMessages'));
        });
    }
}
