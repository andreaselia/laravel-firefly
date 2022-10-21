<?php

namespace Firefly\Test\Feature;

use Carbon\Carbon;
use Firefly\Http\Controllers\DiscussionController;
use Firefly\Services\DiscussionService;
use Firefly\Test\Fixtures\Discussion;
use Firefly\Test\Fixtures\Post;
use Firefly\Test\TestCase;
use Illuminate\Support\Str;

class DiscussionTest extends TestCase
{
    public function test_discussion_was_created()
    {
        // Clear all previous discussions and posts
        Discussion::truncate();
        Post::truncate();

        $response = $this->actingAs($this->getUser())
            ->post('forum/g/example-group/d', [
                'title'   => 'Foo Bar',
                'content' => 'Lorem Ipsum',
            ]);

        $discussions = Discussion::all();

        $this->assertTrue($discussions->count() == 1);
        $this->assertDatabaseHas('discussions', [
            'title' => 'Foo Bar',
            'slug'  => 'foo-bar',
        ]);

        $posts = Post::all();

        $this->assertTrue($posts->count() == 1);
        $this->assertDatabaseHas('posts', [
            'content' => 'Lorem Ipsum',
        ]);

        $discussion = Discussion::first();

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);
    }

    public function test_discussion_was_updated()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())
            ->put('forum/d/'.$discussion->uri, [
                'title' => 'Bar Foo',
            ]);

        $discussion->refresh();

        $this->assertEquals('Bar Foo', $discussion->title);
        $this->assertEquals('bar-foo', $discussion->slug);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);
    }

    public function test_discussion_was_soft_deleted()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())
            ->delete('forum/d/'.$discussion->uri);

        $discussion->refresh();

        $this->assertFalse($discussion->exists());
        $this->assertNotNull($discussion->deleted_at);

        $response->assertRedirect();
        $response->assertLocation('forum');
    }

    public function test_discussion_gets_locked()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())
            ->put('forum/d/'.$discussion->uri.'/lock');

        $discussion->refresh();

        $this->assertNotNull($discussion->locked_at);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);
    }

    public function test_discussion_gets_unlocked()
    {
        $discussion = $this->getDiscussion()->lock();

        $response = $this->actingAs($this->getUser())
            ->put('forum/d/'.$discussion->uri.'/unlock');

        $discussion->refresh();

        $this->assertNull($discussion->locked_at);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);
    }

    public function test_discussion_gets_pinned()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())
            ->put('forum/d/'.$discussion->uri.'/pin');

        $discussion->refresh();

        $this->assertNotNull($discussion->pinned_at);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);
    }

    public function test_discussion_gets_unpinned()
    {
        $discussion = $this->getDiscussion()->pin();

        $response = $this->actingAs($this->getUser())
            ->put('forum/d/'.$discussion->uri.'/unpin');

        $discussion->refresh();

        $this->assertNull($discussion->pinned_at);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);
    }

    public function test_title_is_required()
    {
        $title = '';
        $validJson = [
            'errors' => [
                'title' => [
                    'The title field is required.',
                ],
            ],
        ];

        // Create
        $response = $this->actingAs($this->getUser())
            ->postJson('forum/g/example-group/d', [
                'title' => $title,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
        $response->assertJson($validJson);

        // Update
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())
            ->putJson('forum/d/'.$discussion->uri, [
                'title' => $title,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
        $response->assertJson($validJson);
    }

    public function test_title_has_a_max_of_255_characters()
    {
        $title = Str::random(256);
        $validJson = [
            'errors' => [
                'title' => [
                    'The title must not be greater than 255 characters.',
                ],
            ],
        ];

        // Create
        $response = $this->actingAs($this->getUser())
            ->postJson('forum/g/example-group/d', [
                'title' => $title,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
        $response->assertJson($validJson);

        // Update
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())
            ->putJson('forum/d/'.$discussion->uri, [
                'title' => $title,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
        $response->assertJson($validJson);
    }

    public function test_watcher_was_added_when_discussion_was_created()
    {
        $this->enableWatchersFeature();

        // Clear all previous discussions and posts
        Discussion::truncate();
        Post::truncate();

        $response = $this->actingAs($this->getUser())
            ->post('forum/g/example-group/d', [
                'title'   => 'Foo Bar',
                'content' => 'Lorem Ipsum',
            ]);

        $discussions = Discussion::all();

        $this->assertTrue($discussions->count() == 1);
        $this->assertDatabaseHas('discussions', [
            'title' => 'Foo Bar',
            'slug'  => 'foo-bar',
        ]);

        $posts = Post::all();

        $this->assertTrue($posts->count() == 1);
        $this->assertDatabaseHas('posts', [
            'content' => 'Lorem Ipsum',
        ]);

        $discussion = Discussion::first();

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);

        $this->assertEquals(1, $discussion->watchers()->count());
        $this->assertEquals($this->getUser()->id, $discussion->watchers()->first()->id);
    }

    public function test_sets_initial_post_on_discussion_creation()
    {
        $this->enableFeature('correct_posts');

        // Clear all previous discussions and posts
        Discussion::truncate();
        Post::truncate();

        $response = $this->actingAs($this->getUser())
            ->post('forum/g/example-group/d', [
                'title'   => 'Foo Bar',
                'content' => 'Lorem Ipsum',
            ]);

        $discussions = Discussion::all();

        $this->assertTrue($discussions->count() == 1);
        $this->assertDatabaseHas('discussions', [
            'title' => 'Foo Bar',
            'slug'  => 'foo-bar',
        ]);

        $posts = Post::all();

        $this->assertTrue($posts->count() == 1);
        $this->assertDatabaseHas('posts', [
            'content' => 'Lorem Ipsum',
            'is_initial_post' => 1,
        ]);

        $discussion = Discussion::first();

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);

        $this->assertEquals(Post::first()->id, $discussion->initialPost->id);
        $this->assertEquals(1, Post::first()->is_initial_post);
    }

    public function test_gets_accurate_ordering_with_correct_post()
    {
        $this->enableFeature('correct_posts');

        $secondPost = Post::create([
            'discussion_id' =>$this->getDiscussion()->id,
            'user_id' => $this->getUser()->id,
            'content' => 'Not correct',
        ]);

        $thirdPost = Post::create([
            'discussion_id' =>$this->getDiscussion()->id,
            'user_id' => $this->getUser()->id,
            'content' => 'Correct',
            'corrected_at' => Carbon::now(),
        ]);

        $view = (new DiscussionController(new DiscussionService()))->show($this->getDiscussion());
        $data = $view->getData();
        $posts = $data['posts']->items();

        $expectedPosts = [
            Post::first(),
            $thirdPost,
            $secondPost,
        ];

        foreach ($expectedPosts as $expectedPost) {
            $post = array_shift($posts);

            $this->assertEquals($expectedPost->id, $post->id);
        }
    }
}
