<?php

namespace App\Providers;

use App\Services\MenuService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;

class MenuServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MenuService::class);
    }

    public function boot(): void
    {
        // Set default locale from config
        App::setLocale(config('app.locale', 'th'));

        View::composer('*', function ($view) {
            $view->with('menus', $this->app->make(MenuService::class)->getMenus());
        });
    }
}
