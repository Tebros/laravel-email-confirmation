<?php

namespace Tebros\EmailConfirmation;

use Illuminate\Support\ServiceProvider;

class EmailConfirmationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $packagePath = __DIR__.'/../';
        $this->loadMigrationsFrom($packagePath . 'database/migrations');
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
