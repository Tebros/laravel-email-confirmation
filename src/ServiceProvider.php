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


        //type: php artisan vendor:publish --tag=emailconfirmation-config
        $this->publishes([
            $parentdir.'config/emailconfirmation.php' => config_path('emailconfirmation.php'),
        ], 'emailconfirmation-config');


        $this->loadRoutesFrom($parentdir.'/web.php');


        //migration runs automatically -> dont need to export or move files
        //type: php artisan migrate
        $this->loadMigrationsFrom($parentdir.'database/migrations');


        //trans('package::file.line');
        $this->loadTranslationsFrom($parentdir.'/resources/lang', 'emailconfirmation');
        //type: php artisan vendor:publish --tag=emailconfirmation-translation
        $this->publishes([
            $parentdir.'/resources/lang' => resource_path('lang/vendor/emailconfirmation'),
        ], 'emailconfirmation-translation');


        //referenc is view('package::view')
        $this->loadViewsFrom($parentdir.'/resources/views', 'emailconfirmation');
        //type: php artisan vendor:publish --tag=emailconfirmation-views
        $this->publishes([
            $parentdir.'/resources/views' => resource_path('views/vendor/emailconfirmation'),
        ], 'emailconfirmation-views');


        //type: php artisan vendor:publish --tag=emailconfirmation-controllers
        $this->publishes([
            $parentdir.'/app/Http/Controllers' => app_path('Http/Controllers'),
        ], 'emailconfirmation-controllers');
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
