<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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

        Blade::if('showHistory', function (Article $article) {
            return (User::hasRole(['admin']) || (Auth::check() ? $article->owner_id == Auth::user()->id : false));
        });

        \Carbon\Carbon::setLocale(config('app.locale'));

        Paginator::defaultView("pagination::bootstrap-4");

    }
}
