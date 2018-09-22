<?php

namespace AndreasElia\Firefly\Test;

use AndreasElia\Firefly\FireflyServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app) {
        return [FireflyServiceProvider::class];
    }
}
