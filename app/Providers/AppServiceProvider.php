<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $currentUser = Auth::user();
            $ipFromDB = $currentUser?->ip_address ?? null;
            $view->with('ipFromDB', $ipFromDB);
        });
        Schema::defaultStringLength(191);
        Paginator::useBootstrap(); // Enables Bootstrap-styled pagination links

    }
}
