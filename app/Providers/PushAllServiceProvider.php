<?php

namespace App\Providers;

use App\Services\ExternalAPIRest\PushAll;
use Illuminate\Support\ServiceProvider;

class PushAllServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PushAll::class, function () {
            return new PushAll(PushAll::getChannelByName('common'));
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
