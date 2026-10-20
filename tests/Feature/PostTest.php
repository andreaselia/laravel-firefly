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

    public function test_rich_formatting_is_ignored_when_wysiwyg_is_disabled()
    {
        Post::truncate();

        $discussion = $this->getDiscussion();

        $this->actingAs($this->getUser())
            ->post('forum/d/'.$discussion->uri, [
                'content' => '<img src=x onerror=alert(1)>',
                'formatting' => 'rich',
            ]);

        $this->assertDatabaseHas('posts', [
            'content' => '<img src=x onerror=alert(1)>',
            'formatting' => 'plain',
        ]);

        $this->actingAs($this->getUser())
            ->get('forum/d/'.$discussion->uri)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    public function test_rich_post_is_sanitized_when_wysiwyg_is_enabled()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        Post::truncate();

        $discussion = $this->getDiscussion();

        $this->actingAs($this->getUser())
            ->post('forum/d/'.$discussion->uri, [
                'content' => '<p onclick="alert(1)">Foo <a href="javascript:alert(1)">Bar</a></p><script>alert(1)</script>',
                'formatting' => 'rich',
            ]);

        $this->assertDatabaseHas('posts', [
            'content' => '<p>Foo <a>Bar</a></p>',
            'formatting' => 'rich',
        ]);
    }

    public function test_stored_rich_post_is_sanitized_when_rendered()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $post = $this->getPost();
        $post->forceFill([
            'content' => '<p>Foo</p><img src=x onerror=alert(1)>',
            'formatting' => 'rich',
        ])->save();

        $this->actingAs($this->getUser())
            ->get('forum/d/'.$post->discussion->uri)
            ->assertSee('<p>Foo</p>', false)
            ->assertSee('integrity="sha384-07UbSXbd8HpaOfxZsiO6Y8H1HTX6v0J96b5qP6PKSpYEuSZSYD4GFFHlLRjvjVrL"', false)
            ->assertDontSee('onerror', false);
    }

    public function test_formatting_must_be_plain_or_rich()
    {
        $discussion = $this->getDiscussion();
        $post = $this->getPost();

        $this->actingAs($this->getUser())
            ->postJson('forum/d/'.$discussion->uri, [
                'content' => 'Foo Bar',
                'formatting' => 'html',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('formatting');

        $this->actingAs($this->getUser())
            ->putJson('forum/d/'.$discussion->uri.'/p/'.$post->id, [
                'content' => 'Foo Bar',
                'formatting' => 'html',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('formatting');
    }

    public function test_protected_fields_cannot_be_mass_assigned()
    {
        Post::truncate();

        $discussion = $this->getDiscussion();

        $this->actingAs($this->getUser())
            ->post('forum/d/'.$discussion->uri, [
                'content' => 'Foo Bar',
                'corrected_at' => '2020-01-01 00:00:00',
                'is_initial_post' => 1,
            ]);

        $post = Post::first();

        $this->assertNull($post->corrected_at);
        $this->assertFalse($post->is_initial_post);

        $this->actingAs($this->getUser())
            ->put('forum/d/'.$discussion->uri.'/p/'.$post->id, [
                'content' => 'Bar Foo',
                'corrected_at' => '2020-01-01 00:00:00',
                'is_initial_post' => 1,
            ]);

        $post->refresh();

        $this->assertEquals('Bar Foo', $post->content);
        $this->assertNull($post->corrected_at);
        $this->assertFalse($post->is_initial_post);
    }
}
