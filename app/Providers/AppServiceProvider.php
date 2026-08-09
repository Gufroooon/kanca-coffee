<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;

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
        // Session locale is applied via the SetLocale middleware (runs after session starts).

        // Share available menus with public layout
        View::composer('layouts.app', function ($view) {
            $view->with('globalMenus', Menu::where('is_available', true)->orderBy('name', 'asc')->get());
        });
    }
}

