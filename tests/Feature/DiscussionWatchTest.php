<?php

namespace Firefly\Test\Feature;

use Firefly\Test\TestCase;

class DiscussionWatchTest extends TestCase
{
    public function test_discussion_can_be_watched()
    {
        $this->enableWatchersFeature();

        $discussion = $this->getDiscussion();

        $response = $this->actingAs($this->getUser())->get('forum/d/'.$discussion->uri);
        $response->assertSeeText('Watch');
        $response->assertDontSeeText('Unwatch');

        $response = $this->actingAs($this->getUser())
            ->post('forum/d/'.$discussion->uri.'/watch');

        $discussion->refresh();

        $this->assertEquals(1, $discussion->watchers()->count());

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);
    }

    public function test_discussion_can_be_unwatched()
    {
        $this->enableWatchersFeature();

        $discussion = $this->getDiscussion();
        $discussion->watchers()->save($this->getUser());

        $response = $this->actingAs($this->getUser())->get('forum/d/'.$discussion->uri);
        $response->assertSeeText('Unwatch');
        $response->assertDontSeeText('Watch');

        $this->assertEquals(1, $discussion->watchers()->count());

        $response = $this->actingAs($this->getUser())
            ->delete('forum/d/'.$discussion->uri.'/watch');

        $discussion->refresh();

        $this->assertEquals(0, $discussion->watchers()->count());

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$discussion->uri);
    }
}
