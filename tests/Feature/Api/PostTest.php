<?php

namespace Firefly\Test\Feature\Api;

use Firefly\Test\TestCase;
use Firefly\Test\Fixtures\Post;

class PostTest extends TestCase
{
    public function test_post_gets_created()
    {
        // Clear all previous posts
        Post::truncate();

        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser(), 'api')
            ->postJson('api/forum/' . $discussion->uri, [
                'content' => 'Foo Bar',
            ]);

        $posts = Post::all();

        $this->assertTrue($posts->count() == 1);
        $this->assertDatabaseHas('posts', [
            'content' => 'Foo Bar',
        ]);

        $crawler->assertOk();
        $crawler->assertJsonStructure();
    }

    public function test_post_was_updated()
    {
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $crawler = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/' . $discussion->uri . '/' . $post->id, [
                'content' => 'Bar Foo',
            ]);

        $post->refresh();

        $this->assertEquals('Bar Foo', $post->content);

        $crawler->assertOk();
        $crawler->assertJsonStructure();
    }

    public function test_post_was_soft_deleted()
    {
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $crawler = $this->actingAs($this->getUser(), 'api')
            ->deleteJson('api/forum/' . $discussion->uri . '/' . $post->id);

        $post->refresh();

        $this->assertFalse($post->exists());
        $this->assertNotNull($post->deleted_at);

        $crawler->assertOk();
    }

    public function test_content_is_required()
    {
        $content = '';
        $validJson = [
            'errors' => [
                'content' => [
                    'The content field is required.',
                ]
            ]
        ];

        // Create
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser(), 'api')
            ->postJson('api/forum/' . $discussion->uri, [
                'content' => $content,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('content');
        $crawler->assertJson($validJson);

        // Update
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $crawler = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/' . $discussion->uri . '/' . $post->id, [
                'content' => $content,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('content');
        $crawler->assertJson($validJson);
    }
}
