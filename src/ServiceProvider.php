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


        //publish: php artisan vendor:publish --tag=emailconfirmation-config
        $this->publishes([
            $parentdir.'config/emailconfirmation.php' => config_path('emailconfirmation.php'),
        ], 'emailconfirmation-config');


        $this->app->router->group([
            'namespace' => 'Tebros\EmailConfirmation\Controllers'
        ], function(){
            require __DIR__.'/Routes/web.php';
        });

        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');


        //migration runs automatically -> dont need to export or move files
        //type: php artisan migrate
        $this->loadMigrationsFrom($parentdir.'database/migrations');


        //trans('package::file.line');
        //publish: php artisan vendor:publish --tag=emailconfirmation-translation
        $this->loadTranslationsFrom($parentdir.'resources/lang', 'emailconfirmation');
        $this->publishes([
            $parentdir.'resources/lang' => resource_path('lang/vendor/emailconfirmation'),
        ], 'emailconfirmation-translation');


        //referenc is view('package::view')
        //publish: php artisan vendor:publish --tag=emailconfirmation-views
        $this->loadViewsFrom($parentdir.'resources/views', 'emailconfirmation');
        $this->publishes([
            $parentdir.'resources/views' => resource_path('views/vendor/emailconfirmation'),
        ], 'emailconfirmation-views');

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
