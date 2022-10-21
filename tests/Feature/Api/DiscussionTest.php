<?php

namespace Firefly\Test\Feature\Api;

use Carbon\Carbon;
use Firefly\Test\Fixtures\Discussion;
use Firefly\Test\Fixtures\Post;
use Firefly\Test\TestCase;

class DiscussionTest extends TestCase
{
    public function test_discussion_was_created()
    {
        // Clear all previous discussions and posts
        Discussion::truncate();
        Post::truncate();

        $response = $this->actingAs($this->getUser(), 'api')
            ->postJson('api/forum/d', [
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

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function test_discussions_were_listed()
    {
        $response = $this->actingAs($this->getUser(), 'api')
            ->getJson('api/forum/d');

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function test_discussion_was_listed()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser(), 'api')
            ->getJson('api/forum/d/'.$discussion->id);

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function test_discussion_was_updated()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/d/'.$discussion->id, [
                'title' => 'Bar Foo',
            ]);

        $discussion->refresh();

        $this->assertEquals('Bar Foo', $discussion->title);
        $this->assertEquals('bar-foo', $discussion->slug);

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function test_discussion_was_soft_deleted()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser(), 'api')
            ->deleteJson('api/forum/d/'.$discussion->id);

        $discussion->refresh();

        $this->assertFalse($discussion->exists());
        $this->assertNotNull($discussion->deleted_at);

        $response->assertOk();
    }

    public function test_discussion_was_locked()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/d/'.$discussion->uri.'/lock');

        $discussion->refresh();

        $this->assertNotNull($discussion->locked_at);

        $response->assertOk();
    }

    public function test_discussion_was_unlocked()
    {
        $discussion = $this->getDiscussion()->lock();

        $response = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/d/'.$discussion->uri.'/unlock');

        $discussion->refresh();

        $this->assertNull($discussion->locked_at);

        $response->assertOk();
    }

    public function test_discussion_was_pinned()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/d/'.$discussion->uri.'/pin');

        $discussion->refresh();

        $this->assertNotNull($discussion->pinned_at);

        $response->assertOk();
    }

    public function test_discussion_was_unpinned()
    {
        $discussion = $this->getDiscussion()->pin();

        $response = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/d/'.$discussion->uri.'/unpin');

        $discussion->refresh();

        $this->assertNull($discussion->pinned_at);

        $response->assertOk();
    }

    public function test_watcher_was_added_when_discussion_was_created()
    {
        $this->enableWatchersFeature();

        // Clear all previous discussions and posts
        Discussion::truncate();
        Post::truncate();

        $response = $this->actingAs($this->getUser(), 'api')
            ->postJson('api/forum/d', [
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

        $response->assertOk();
        $response->assertJsonStructure();

        $this->assertEquals(1, $discussion->watchers()->count());
        $this->assertEquals($this->getUser()->id, $discussion->watchers()->first()->id);
    }

    public function test_sets_initial_post_on_discussion_creation()
    {
        $this->enableFeature('correct_posts');

        // Clear all previous discussions and posts
        Discussion::truncate();
        Post::truncate();

        $response = $this->actingAs($this->getUser(), 'api')
            ->postJson('api/forum/d', [
                'group_id' => $this->getGroup()->id,
                'title' => 'Foo Bar',
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

        $response->assertOk();
        $response->assertJsonStructure();

        $this->assertEquals(Post::first()->id, $discussion->initialPost->id);
        $this->assertEquals(1, Post::first()->is_initial_post);
    }

    public function test_gets_accurate_ordering_with_correct_post()
    {
        $this->enableFeature('correct_posts');
        $discussion = $this->getDiscussion();

        $secondPost = Post::create([
            'discussion_id' => $discussion->id,
            'user_id' => $this->getUser()->id,
            'content' => 'Not correct',
        ]);

        $thirdPost = Post::create([
            'discussion_id' =>$this->getDiscussion()->id,
            'user_id' => $this->getUser()->id,
            'content' => 'Correct',
            'corrected_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($this->getUser(), 'api')
            ->getJson('api/forum/d/'.$discussion->id);

        $posts = $response->json('posts')['data'];

        $response->assertOk();
        $response->assertJsonStructure();

        $expectedPosts = [
            Post::first(),
            $thirdPost,
            $secondPost,
        ];

        foreach ($expectedPosts as $expectedPost) {
            $post = array_shift($posts);

            $this->assertEquals($expectedPost->id, $post['id']);
        }
    }
}
