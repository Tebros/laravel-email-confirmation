<?php

namespace Tebros\EmailConfirmation;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //dir of package
        $parentdir = __DIR__.'/../';

        //migration runs automatically -> dont need to export or move files
        $this->loadMigrationsFrom($parentdir . 'database/migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
