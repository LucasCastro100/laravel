<?php

namespace App\Providers;

use App\Models\Dashboard\Aside;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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
       view()->composer('pages.auth.dashboard.*', function ($view) {
        $aside = New Aside;
           $userRole = Auth::user()->role->value;
           $listMenu = $aside->getMenuByRoles($userRole);
           $view->with('menuRoles', $listMenu);
       });
    }
}
