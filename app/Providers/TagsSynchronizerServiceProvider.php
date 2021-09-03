<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TagsSynchronizer;

class TagsSynchronizerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TagsSynchronizer::class, function() {
            return new TagsSynchronizer;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
