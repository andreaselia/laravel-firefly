<?php

namespace Firefly\Test\Feature\Api;

use Firefly\Test\Fixtures\Post;
use Firefly\Test\TestCase;
use Firefly\Test\Fixtures\Discussion;

class DiscussionTest extends TestCase
{
    public function test_discussion_was_created()
    {
        // Clear all previous discussions and posts
        Discussion::truncate();
        Post::truncate();

        $crawler = $this->actingAs($this->getUser(), 'api')
            ->postJson('api/forum/discussions', [
                'group_id' => $this->getGroup()->id,
                'title' => 'Foo Bar',
                'content' => 'Lorem Ipsum',
            ]);

        $discussions = Discussion::all();

        $this->assertTrue($discussions->count() == 1);
        $this->assertDatabaseHas('discussions', [
            'title' => 'Foo Bar',
            'slug' => 'foo-bar',
        ]);

        $posts = Post::all();

        $this->assertTrue($posts->count() == 1);
        $this->assertDatabaseHas('posts', [
            'content' => 'Lorem Ipsum',
        ]);

        $discussion = Discussion::first();

        $crawler->assertOk();
        $crawler->assertJsonStructure();
    }
}