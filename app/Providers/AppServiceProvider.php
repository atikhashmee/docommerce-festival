<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();
        view()->composer('layouts._menu', function ($view) {
            $view->with('categories', \App\Models\Category::join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
            ->where('category_festivals.festival_id', 7)->get());
        });
    }
}
