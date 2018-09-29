<?php

namespace Firefly\Test\Feature;

use Firefly\Test\Fixtures\Discussion;
use Firefly\Test\Fixtures\User;
use Firefly\Test\TestCase;

class DiscussionTest extends TestCase
{
    public function test_discussion_was_created()
    {
        // Clear all previous discussions
        Discussion::truncate();

        $crawler = $this->actingAs($this->getUser())
            ->post('forum/example-tag/discussion', [
                'title' => 'Foo Bar',
            ]);

        $discussions = Discussion::all();

        $this->assertTrue($discussions->count() == 1);
        $this->assertDatabaseHas('discussions', [
            'title' => 'Foo Bar',
            'slug' => 'foo-bar',
        ]);

        $discussion = Discussion::first();

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $discussion->uri);
    }

    public function test_discussion_was_updated()
    {
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/' . $discussion->uri, [
                'title' => 'Bar Foo',
            ]);

        $discussion = $this->getDiscussion()->refresh();

        $this->assertEquals('Bar Foo', $discussion->title);
        $this->assertEquals('bar-foo', $discussion->slug);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $discussion->uri);
    }

    public function test_discussion_was_soft_deleted()
    {
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->delete('forum/' . $discussion->uri);

        $discussion = $this->getDiscussion()->refresh();

        $this->assertFalse($discussion->exists());
        $this->assertNotNull($discussion->deleted_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum');
    }

    public function test_discussion_gets_locked()
    {
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/' . $discussion->uri . '/lock');

        $discussion = $this->getDiscussion()->refresh();

        $this->assertNotNull($discussion->locked_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $discussion->uri);
    }

    public function test_discussion_gets_unlocked()
    {
        $discussion = $this->getDiscussion()->lock();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/' . $discussion->uri . '/unlock');

        $discussion = $this->getDiscussion()->refresh();

        $this->assertNull($discussion->locked_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $discussion->uri);
    }

    public function test_discussion_gets_stickied()
    {
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/' . $discussion->uri . '/stick');

        $discussion = $this->getDiscussion()->refresh();

        $this->assertNotNull($discussion->stickied_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $discussion->uri);
    }

    public function test_discussion_gets_unstickied()
    {
        $discussion = $this->getDiscussion()->lock();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/' . $discussion->uri . '/unstick');

        $discussion = $this->getDiscussion()->refresh();

        $this->assertNull($discussion->stickied_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $discussion->uri);
    }
}