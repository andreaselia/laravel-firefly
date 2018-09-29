<?php

namespace Firefly\Test;

use Firefly\Test\Fixtures\Post;
use Firefly\Test\TestCase;

class PostTest extends TestCase
{
    public function test_post_gets_created()
    {
        // Clear all previous posts
        Post::truncate();

        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->post('forum/' . $discussion->uri, [
                'content' => 'Foo Bar',
            ]);

        $posts = Post::all();

        $this->assertTrue($posts->count() == 1);
        $this->assertDatabaseHas('posts', [
            'content' => 'Foo Bar',
        ]);

        $crawler->assertOk();
        $crawler->assertJson([
            'content' => 'Foo Bar',
        ]);
    }

    public function test_post_was_updated()
    {
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/' . $discussion->uri . '/' . $post->id, [
                'content' => 'Bar Foo',
            ]);

        $post->refresh();

        $this->assertEquals('Bar Foo', $post->content);

        $crawler->assertOk();
        $crawler->assertJson([
            'content' => 'Bar Foo',
        ]);
    }
}