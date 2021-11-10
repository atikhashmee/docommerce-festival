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
        view()->composer('layouts._menu', function ($view)  {
            $festival = getFestival();
            $view->with('categories', \App\Models\Category::select("categories.*")
            ->join('category_festivals', 'category_festivals.category_id', '=', 'categories.id')
            ->leftJoin(\DB::raw("(SELECT COUNT(id) as total_product, category_id FROM products GROUP BY category_id) as P"), "P.category_id", "=", "categories.id")
            ->where("P.total_product", ">", 0)
            ->where('category_festivals.festival_id', $festival->id)->get());
        });
    }
}
