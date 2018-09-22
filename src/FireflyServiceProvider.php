<?php

namespace Firefly;

use Illuminate\Support\ServiceProvider;

class FireflyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrations();
        $this->defineAssetPublishing();
        $this->registerRoutes();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfiguration();
    }

    /**
     * Load the package migrations.
     *
     * @return void
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Merge the package configuration with the application.
     *
     * @return void
     */
    protected function mergeConfiguration()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/firefly.php', 'firefly'
        );
    }

    /**
     * Register the api and web routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        $this->registerApiRoutes();
        $this->registerWebRoutes();
    }

    /**
     * Define the web routes.
     *
     * @return void
     */
    protected function registerWebRoutes()
    {
        Route::group([
            'prefix' => config('firefly.web.prefix'),
            'namespace' => config('firefly.web.namespace'),
            'middleware' => config('firefly.web.middleware'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Define the api routes.
     *
     * @return void
     */
    protected function registerApiRoutes()
    {
        if (config('firefly.api.enabled')) {
            Route::group([
                'prefix' => config('firefly.api.prefix'),
                'namespace' => config('firefly.api.namespace'),
                'middleware' => config('firefly.api.middleware'),
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
            });
        }
    }

    /**
     * Define the assets that can be published.
     *
     * @return void
     */
    protected function defineAssetPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/firefly.php' => config_path('firefly.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }
}
