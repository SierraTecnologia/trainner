<?php

namespace Trainner;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Trainner\Services\TrainnerService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

use Log;
use App;
use Config;
use Route;
use Illuminate\Routing\Router;

use Support\ClassesHelpers\Traits\Models\ConsoleTools;

use Trainner\Facades\Trainner as TrainnerFacade;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class TrainnerProvider extends ServiceProvider
{
    use ConsoleTools;

    public static $aliasProviders = [
        'Trainner' => \Trainner\Facades\Trainner::class,
    ];

    public static $providers = [
        // \Trainner\Providers\TrainnerEventServiceProvider::class,
        // \Trainner\Providers\TrainnerServiceProvider::class,
        // \Trainner\Providers\TrainnerRouteProvider::class,

        \Finder\FinderProvider::class,
        \Gamer\GamerProvider::class,
        \Casa\CasaProvider::class,
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [
        'Profile' => [
            [
                'text' => 'Trainner',
                'icon' => 'fas fa-fw fa-gavel',
            ],
            'Trainner' => [
                [
                    'text'        => 'Treinos',
                    'route'       => 'trainner.home', //route('trainner.home'),
                    'icon'        => 'fas fa-fw fa-gavel',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    // 'access' => \App\Models\Role::$ADMIN
                ]
            ],
        ],
    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        // $this->app->booted(function () {
        //     $this->routes();
        // });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        /**
         * Trainner Routes
         */
        Route::group([
            'namespace' => '\Trainner\Http\Controllers',
        ], function ($router) {
            require __DIR__.'/Routes/web.php';
        });
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getPublishesPath('config/sitec/trainner.php'), 'sitec.trainner');
        

        $this->setProviders();
        $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $loader = AliasLoader::getInstance();
        $loader->alias('Trainner', TrainnerFacade::class);

        $this->app->singleton('trainner', function () {
            return new Trainner();
        });
        
        /*
        |--------------------------------------------------------------------------
        | Register the Utilities
        |--------------------------------------------------------------------------
        */
        /**
         * Singleton Trainner
         */
        $this->app->singleton(TrainnerService::class, function($app)
        {
            Log::info('Singleton Trainner');
            return new TrainnerService(config('sitec.trainner'));
        });

        // Register commands
        $this->registerCommandFolders([
            base_path('vendor/sierratecnologia/trainner/src/Console/Commands') => '\Trainner\Console\Commands',
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'trainner',
        ];
    }

    /**
     * Register configs, migrations, etc
     *
     * @return void
     */
    public function registerDirectories()
    {
        // Publish config files
        $this->publishes([
            // Paths
            $this->getPublishesPath('config/sitec') => config_path('sitec'),
        ], ['config',  'sitec', 'sitec-config']);

        // // Publish trainner css and js to public directory
        // $this->publishes([
        //     $this->getDistPath('trainner') => public_path('assets/trainner')
        // ], ['public',  'sitec', 'sitec-public']);

        $this->loadViews();
        $this->loadTranslations();

    }

    private function loadViews()
    {
        // View namespace
        $viewsPath = $this->getResourcesPath('views');
        $this->loadViewsFrom($viewsPath, 'trainner');
        $this->publishes([
            $viewsPath => base_path('resources/views/vendor/trainner'),
        ], ['views',  'sitec', 'sitec-views']);

    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes([
            $this->getResourcesPath('lang') => resource_path('lang/vendor/trainner')
        ], ['lang',  'sitec', 'sitec-lang', 'translations']);

        // Load translations
        $this->loadTranslationsFrom($this->getResourcesPath('lang'), 'trainner');
    }


}
