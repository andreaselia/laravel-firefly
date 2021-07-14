<?php

namespace Firefly\Test\Unit;

use Firefly\Features;
use Firefly\Test\TestCase;

class FeaturesTest extends TestCase
{
    public function test_can_get_enabled_status()
    {
        $this->assertFalse(Features::enabled('test'));

        $this->enableWatchersFeature();
        $this->assertTrue(Features::enabled('watchers'));

        $this->app->config->set('firefly.features.wysiwyg', [
            'enabled' => true,
        ]);
        $this->assertTrue(Features::enabled('wysiwyg'));

        $this->app->config->set('firefly.features.experimental', [
            'enabled' => false,
        ]);
        $this->assertFalse(Features::enabled('experimental'));
    }

    public function test_can_get_anonymous_enabled_status()
    {
        $this->assertFalse(Features::hasTestFeature());

        $this->enableWatchersFeature();
        $this->assertTrue(Features::hasWatchersFeature());

        $this->app->config->set('firefly.features.wysiwyg', [
            'enabled' => true,
        ]);
        $this->assertTrue(Features::hasWysiwygFeature());
    }

    public function test_does_throw_exception_on_nonexistent_method()
    {
        try {
            $response = Features::doesntHaveFeature();
        } catch (\BadMethodCallException $exception) {
            $this->assertNotNull($exception);

            return;
        }

        $this->fail('Did not throw bad method call exception on non-existent static method');
    }

    public function test_can_get_feature_option()
    {
        $this->app->config->set('firefly.features.wysiwyg', [
            'enabled' => true,
            'theme'   => 'snow',
        ]);

        $this->assertTrue(Features::enabled('wysiwyg'));
        $this->assertEquals('snow', Features::option('wysiwyg', 'theme'));
    }
}
