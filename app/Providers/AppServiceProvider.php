<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        Schema::defaultStringLength(191);
        
        view()->composer('layouts.sidebar', function($view) {
            $view->with('tagsCloud', Tag::has('articles')->get());
        });

        Blade::if('admin', function () {
            return User::hasRole(['admin']);
        });

    }
}
