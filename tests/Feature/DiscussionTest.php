<?php

namespace Firefly\Test\Feature;

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

        $crawler = $this->actingAs($this->getUser())
            ->post('forum/g/example-group/d', [
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

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/d/' . $discussion->uri);
    }

    public function test_discussion_was_updated()
    {
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/d/' . $discussion->uri, [
                'title' => 'Bar Foo',
            ]);

        $discussion->refresh();

        $this->assertEquals('Bar Foo', $discussion->title);
        $this->assertEquals('bar-foo', $discussion->slug);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/d/' . $discussion->uri);
    }

    public function test_discussion_was_soft_deleted()
    {
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->delete('forum/d/' . $discussion->uri);

        $discussion->refresh();

        $this->assertFalse($discussion->exists());
        $this->assertNotNull($discussion->deleted_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum');
    }

    public function test_discussion_gets_locked()
    {
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/d/' . $discussion->uri . '/lock');

        $discussion->refresh();

        $this->assertNotNull($discussion->locked_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/d/' . $discussion->uri);
    }

    public function test_discussion_gets_unlocked()
    {
        $discussion = $this->getDiscussion()->lock();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/d/' . $discussion->uri . '/unlock');

        $discussion->refresh();

        $this->assertNull($discussion->locked_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/d/' . $discussion->uri);
    }

    public function test_discussion_gets_pinned()
    {
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/d/' . $discussion->uri . '/pin');

        $discussion->refresh();

        $this->assertNotNull($discussion->pinned_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/d/' . $discussion->uri);
    }

    public function test_discussion_gets_unpinned()
    {
        $discussion = $this->getDiscussion()->pin();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/d/' . $discussion->uri . '/unpin');

        $discussion->refresh();

        $this->assertNull($discussion->pinned_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/d/' . $discussion->uri);
    }

    public function test_title_is_required()
    {
        $title = '';
        $validJson = [
            'errors' => [
                'title' => [
                    'The title field is required.',
                ]
            ]
        ];

        // Create
        $crawler = $this->actingAs($this->getUser())
            ->postJson('forum/g/example-group/d', [
                'title' => $title,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('title');
        $crawler->assertJson($validJson);

        // Update
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->putJson('forum/d/' . $discussion->uri, [
                'title' => $title,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('title');
        $crawler->assertJson($validJson);
    }

    public function test_title_has_a_max_of_255_characters()
    {
        $title = str_random(256);
        $validJson = [
            'errors' => [
                'title' => [
                    'The title may not be greater than 255 characters.',
                ]
            ]
        ];

        // Create
        $crawler = $this->actingAs($this->getUser())
            ->postJson('forum/g/example-group/d', [
                'title' => $title,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('title');
        $crawler->assertJson($validJson);

        // Update
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->putJson('forum/d/' . $discussion->uri, [
                'title' => $title,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('title');
        $crawler->assertJson($validJson);
    }
}
