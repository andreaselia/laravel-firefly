<?php

namespace Firefly\Test;

use Carbon\Carbon;
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

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $discussion->uri);
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

    public function test_post_was_soft_deleted()
    {
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $crawler = $this->actingAs($this->getUser())
            ->delete('forum/' . $discussion->uri . '/' . $post->id);

        $post->refresh();

        $this->assertFalse($post->exists());
        $this->assertNotNull($post->deleted_at);

        $crawler->assertOk();
    }

    public function test_post_was_hidden_successfully()
    {
        $post = $this->getPost();

        $crawler = $this->actingAs($this->getUser())
            ->patchJson('forum/posts/' . $post->id . '/hide');

        $post->refresh();

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $post->discussion->uri);
        
        $this->assertNotNull($post->hidden_at);
        $this->assertInstanceOf(Carbon::class, $post->hidden_at);
    }

    public function test_post_was_unhidden_successfully()
    {
        $post = $this->getPost()->hide();

        $crawler = $this->actingAs($this->getUser())
            ->patchJson('forum/posts/' . $post->id . '/unhide');
        
        $post->refresh();

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $post->discussion->uri);

        $this->assertNull($post->hidden_at);
        $this->assertNotInstanceOf(Carbon::class, $post->hidden_at);
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

        $crawler = $this->actingAs($this->getUser())
            ->postJson('forum/' . $discussion->uri, [
                'content' => $content,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('content');
        $crawler->assertJson($validJson);

        // Update
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $crawler = $this->actingAs($this->getUser())
            ->putJson('forum/' . $discussion->uri . '/' . $post->id, [
                'content' => $content,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('content');
        $crawler->assertJson($validJson);
    }

    public function test_title_has_at_least_5_characters()
    {
        $content = 'Foo';
        $validJson = [
            'errors' => [
                'content' => [
                    'The content must be at least 5 characters.',
                ]
            ]
        ];

        // Create
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->postJson('forum/' . $discussion->uri, [
                'content' => $content,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('content');
        $crawler->assertJson($validJson);

        // Update
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $crawler = $this->actingAs($this->getUser())
            ->putJson('forum/' . $discussion->uri . '/' . $post->id, [
                'content' => $content,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('content');
        $crawler->assertJson($validJson);
    }
}