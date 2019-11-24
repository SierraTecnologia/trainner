<?php

namespace Trainner;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TrainnerProvider extends ServiceProvider
{
    public static $providers = [
        // \Trainner\Providers\TrainnerEventServiceProvider::class,
        // \Trainner\Providers\TrainnerServiceProvider::class,
        // \Trainner\Providers\TrainnerRouteProvider::class,

        \Casa\CasaProvider::class,
    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        // $this->publishes([
        //     __DIR__.'/Publishes/resources/tools' => base_path('resources/tools'),
        //     __DIR__.'/Publishes/app/Services' => app_path('Services'),
        //     __DIR__.'/Publishes/public/js' => base_path('public/js'),
        //     __DIR__.'/Publishes/public/css' => base_path('public/css'),
        //     __DIR__.'/Publishes/public/img' => base_path('public/img'),
        //     __DIR__.'/Publishes/config' => base_path('config'),
        //     __DIR__.'/Publishes/routes' => base_path('routes'),
        //     __DIR__.'/Publishes/app/Controllers' => app_path('Http/Controllers/Trainner'),
        // ]);

        // $this->publishes([
        //     __DIR__.'../resources/views' => base_path('resources/views/vendor/Trainner'),
        // ], 'SierraTecnologia Trainner');
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->setProviders();

        // // View namespace
        // $this->loadViewsFrom(__DIR__.'/Views', 'Trainner');

        // if (is_dir(base_path('resources/Trainner'))) {
        //     $this->app->view->addNamespace('Trainner-frontend', base_path('resources/Trainner'));
        // } else {
        //     $this->app->view->addNamespace('Trainner-frontend', __DIR__.'/Publishes/resources/Trainner');
        // }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // // Configs
        // $this->app->config->set('Trainner.modules.Trainner', include(__DIR__.'/config.php'));

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

        $this->commands([]);
    }

    protected function setProviders()
    {
        collection(self::$providers)->map(function ($provider) {
            $this->app->register($provider);
        })

    }

}
