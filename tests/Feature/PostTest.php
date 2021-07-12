<?php

namespace Firefly\Test;

use Firefly\Mail\PostAddedEmail;
use Firefly\Test\Fixtures\Post;
use Firefly\Test\Fixtures\User;
use Illuminate\Support\Facades\Mail;

class PostTest extends TestCase
{
    public function test_post_gets_created()
    {
        // Clear all previous posts
        Post::truncate();

        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())
            ->postJson('forum/d/'.$discussion->uri, [
                'content' => 'Foo Bar',
            ]);

        $posts = Post::all();

        $this->assertTrue($posts->count() == 1);
        $this->assertDatabaseHas('posts', [
            'content' => 'Foo Bar',
        ]);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);
    }

    public function test_post_was_updated()
    {
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $response = $this->actingAs($this->getUser())
            ->put('forum/d/'.$discussion->uri.'/p/'.$post->id, [
                'content' => 'Bar Foo',
            ]);

        $post->refresh();

        $this->assertEquals('Bar Foo', $post->content);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$post->discussion->uri);
    }

    public function test_post_was_soft_deleted()
    {
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $response = $this->actingAs($this->getUser())
            ->delete('forum/d/'.$discussion->uri.'/p/'.$post->id);

        $post->refresh();

        $this->assertFalse($post->exists());
        $this->assertNotNull($post->deleted_at);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$post->discussion->uri);
    }

    public function test_content_is_required()
    {
        $content = '';
        $validJson = [
            'errors' => [
                'content' => [
                    'The content field is required.',
                ],
            ],
        ];

        // Create
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())
            ->postJson('forum/d/'.$discussion->uri, [
                'content' => $content,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('content');
        $response->assertJson($validJson);

        // Update
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $response = $this->actingAs($this->getUser())
            ->putJson('forum/d/'.$discussion->uri.'/p/'.$post->id, [
                'content' => $content,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('content');
        $response->assertJson($validJson);
    }

    public function test_watcher_gets_added_when_post_gets_created()
    {
        $this->enableWatchersFeature();
        // Clear all previous posts
        Post::truncate();

        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())
            ->postJson('forum/d/'.$discussion->uri, [
                'content' => 'Foo Bar',
            ]);

        $posts = Post::all();

        $this->assertTrue($posts->count() == 1);
        $this->assertDatabaseHas('posts', [
            'content' => 'Foo Bar',
        ]);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);

        $this->assertEquals(1, $discussion->watchers()->count());
        $this->assertEquals($this->getUser()->id, $discussion->watchers()->first()->id);
    }

    public function test_email_gets_sent_to_watchers_when_post_gets_created()
    {
        $this->enableWatchersFeature();
        Mail::fake();

        $watchingUser = User::create([
            'email'=>'watching@example.com',
            'name'=>'watching Rat',
            'password' => bcrypt('password'),
        ]);

        // Clear all previous posts
        Post::truncate();

        $discussion = $this->getDiscussion();

        $discussion->watchers()->syncWithoutDetaching([$watchingUser->id]);
        $this->assertEquals(1, $discussion->watchers()->count());
        $this->assertEquals($watchingUser->id, $discussion->watchers()->first()->id);

        $response = $this->actingAs($this->getUser())
            ->postJson('forum/d/'.$discussion->uri, [
                'content' => 'Foo Bar',
            ]);

        $posts = Post::all();

        $this->assertTrue($posts->count() == 1);
        $this->assertDatabaseHas('posts', [
            'content' => 'Foo Bar',
        ]);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);

        $this->assertEquals(2, $discussion->watchers()->count());

        Mail::assertSent(PostAddedEmail::class, function ($message) {
            $this->assertEquals('watching@example.com', $message->to[0]['address']);

            return true;
        });
    }
}
