<?php

namespace Firefly\Test\Feature\Api;

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

    public function test_discussion_can_be_watched()
    {
        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/d/'.$discussion->uri.'/watch');

        $discussion->refresh();

        $this->assertEquals(1, $discussion->watchers()->count());

        $response->assertOk();
    }

    public function test_discussion_can_be_unwatched()
    {
        $discussion = $this->getDiscussion();
        $discussion->watchers()->save($this->getUser());

        $this->assertEquals(1, $discussion->watchers()->count());

        $response = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/d/'.$discussion->uri.'/unwatch');

        $discussion->refresh();

        $this->assertEquals(0, $discussion->watchers()->count());

        $response->assertOk();
    }
}
