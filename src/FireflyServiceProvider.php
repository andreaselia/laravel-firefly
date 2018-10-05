<?php

namespace Firefly;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FireflyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the package.
     *
     * @var array
     */
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
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');
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
