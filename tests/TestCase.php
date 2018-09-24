<?php

namespace Firefly\Test;

use Firefly\FireflyServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations();

        $this->withFactories(__DIR__.'/../database/factories');

        $this->artisan('migrate')->run();
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [FireflyServiceProvider::class];
    }
}
