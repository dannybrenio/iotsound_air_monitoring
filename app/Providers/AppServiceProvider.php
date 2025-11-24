<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\History_status;

use Illuminate\Support\ServiceProvider;

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
        // Share unread notifications with all views
        View::composer('*', function ($view) {
            $notifs = History_status::where('isRead', 0)
                        ->orderBy('created_at', 'desc')
                        ->get();
            $view->with('notifs', $notifs);
        });
    }
}
