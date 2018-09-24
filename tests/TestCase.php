<?php

namespace Firefly\Test;

use Firefly\FireflyServiceProvider;
use Firefly\Test\Fixtures\Post;
use Firefly\Test\Fixtures\Discussion;
use Firefly\Test\Fixtures\Group;
use Firefly\Test\Fixtures\User;
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

        $this->setupDatabase();
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

    /**
     * Add all of the dummy models.
     *
     * @return void
     */
    protected function setupDatabase()
    {
        $user = User::create([
            'name' => 'Test Rat',
            'email' => 'test@example.com',
            'password' => bcrypt('secret')
        ]);

        $group = Group::create([
            'name' => 'Example Group',
            'slug' => 'example-group',
            'color' => '#2964c4',
        ]);

        $discussion = Discussion::create([
            'user_id' => $user->id,
            'title' => 'Example Discsussion',
            'slug' => 'example-discussion',
        ]);

        $post = Post::create([
            'discussion_id' => $discussion->id,
            'user_id' => $user->id,
            'content' => 'Lorem ipsum',
        ]);
    }
}
