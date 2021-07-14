<?php

namespace Firefly;

use Firefly\Events\PostAdded;
use Firefly\Listeners\NotifyWatchersPostAdded;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FireflyServiceProvider extends ServiceProvider
{
    /** @var array */
    protected $policies = [
        'Firefly\Models\Discussion' => 'Firefly\Policies\DiscussionPolicy',
        'Firefly\Models\Group' => 'Firefly\Policies\GroupPolicy',
        'Firefly\Models\Post' => 'Firefly\Policies\PostPolicy',
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
        $this->registerEvents();
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

        Blade::component('firefly::components.button', 'button');
        Blade::component('firefly::components.input', 'input');
        Blade::component('firefly::components.textarea', 'textarea');
        Blade::component('firefly::components.label', 'label');
        Blade::component('firefly::components.card', 'card');
        Blade::component('firefly::components.no-results', 'no-results');
        Blade::component('firefly::components.validation-errors', 'validation-errors');
        Blade::component('firefly::components.icon', 'icon');
        Blade::component('firefly::components.tag', 'tag');
        Blade::component('firefly::components.header', 'header');
        Blade::component('firefly::components.discussion-item', 'discussion-item');
        Blade::component('firefly::components.discussion-options', 'discussion-options');
        Blade::component('firefly::components.group-options', 'group-options');
        Blade::component('firefly::components.group-item', 'group-item');
        Blade::component('firefly::components.post-item', 'post-item');
        Blade::component('firefly::components.quill-js', 'quill-js');
        Blade::component('firefly::components.rich-textarea', 'rich-textarea');
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

    /**
     * Register the package's events.
     *
     * @return void
     */
    private function registerEvents()
    {
        Event::listen(
            PostAdded::class,
            [NotifyWatchersPostAdded::class, 'handle']
        );
    }
}
