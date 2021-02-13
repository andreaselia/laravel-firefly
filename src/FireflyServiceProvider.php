<?php

namespace Firefly;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FireflyServiceProvider extends ServiceProvider
{
    /** @var array */
    protected $policies = [
        'Firefly\Discussion' => 'Firefly\Policies\DiscussionPolicy',
        'Firefly\Group' => 'Firefly\Policies\GroupPolicy',
        'Firefly\Post' => 'Firefly\Policies\PostPolicy',
    ];

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
        $this->registerPolicies();
        $this->loadViews();
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
     * Load the package views.
     *
     * @return void
     */
    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'firefly');
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
        $this->registerWebRoutes();
        $this->registerApiRoutes();
    }

    /**
     * Define the web routes.
     *
     * @return void
     */
    protected function registerWebRoutes()
    {
        if (config('firefly.web.enabled')) {
            Route::group(config('firefly.web'), function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            });
        }
    }

    /**
     * Define the api routes.
     *
     * @return void
     */
    protected function registerApiRoutes()
    {
        if (config('firefly.api.enabled')) {
            Route::group(config('firefly.api'), function () {
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
            __DIR__.'/../config/firefly.php' => config_path('firefly.php'),
        ], 'firefly-config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'firefly-migrations');

        $this->publishes([
            __DIR__.'/../public/' => public_path('vendor/firefly'),
        ], 'firefly-assets');
    }

    /**
     * Register the package's policies.
     *
     * @return void
     */
    private function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
}
