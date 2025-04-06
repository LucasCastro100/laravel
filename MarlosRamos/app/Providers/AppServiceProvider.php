<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        View::composer('*', function ($view) {
            $menu = [];
    
            if (Auth::check() && Auth::user()->role == 1) {
                $menu = config('menuDashboard.admin');
            }
    
            $view->with('adminMenu', $menu);
        });
    }
}
