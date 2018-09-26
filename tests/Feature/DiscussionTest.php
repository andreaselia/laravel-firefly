<?php

namespace Firefly\Test;

use Firefly\Test\Fixtures\Discussion;
use Firefly\Test\Fixtures\User;

class DiscussionTest extends TestCase
{
    public function test_discussion_was_created()
    {
        $crawler = $this->actingAs($this->getUser())
            ->postJson('forum/example-tag/discussion', [
                'title' => 'Foo Bar',
            ]);

        $discussions = Discussion::all();

        $this->assertTrue($discussions->count() == 2);

        $this->assertDatabaseHas('discussions', [
            'title' => 'Foo Bar',
            'slug' => 'foo-bar',
        ]);
    }

    public function test_discussion_was_updated()
    {
        $discussion = $this->getDiscussion();

        $crawler = $this->actingAs($this->getUser())
            ->putJson('forum/' . $discussion->uri, [
                'title' => 'Bar Foo',
            ]);

        $discussion = $this->getDiscussion()->refresh();

        $this->assertTrue($discussion->title == 'Bar Foo');

        $this->assertTrue($discussion->slug == 'bar-foo');
    }
}