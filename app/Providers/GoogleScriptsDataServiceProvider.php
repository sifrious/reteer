<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GoogleScriptsDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('App\Services\GoogleDataService', function ($app) {
            return new \App\Services\GoogleDataService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
