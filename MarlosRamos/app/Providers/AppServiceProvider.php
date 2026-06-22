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
        if (str_starts_with(config('app.url'), 'https://') || ($this->app->request->isSecure() ?? false)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $menu = [];
        
            if (Auth::check() && Auth::user()->role_id && Auth::user()->role->name) {
                $roleName = Auth::user()->role->name;
        
                $menus = config('menuDashboard');
        
                if (array_key_exists($roleName, $menus)) {
                    $menu = $menus[$roleName];
                }
            }
        
            $view->with('adminMenu', $menu);
        });
    }
}
