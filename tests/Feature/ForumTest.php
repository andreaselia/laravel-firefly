<?php

namespace Firefly\Test\Feature;

use Firefly\Test\TestCase;

class ForumTest extends TestCase
{
    public function test_can_get_discussion_list()
    {
        $response = $this->actingAs($this->getUser())
            ->get('forum/');

        $discussions = $response->viewData('discussions');

        $this->assertEquals(1, $discussions->count());

        $this->assertEquals($this->getDiscussion()->id, $discussions->first()->id);
    }

    public function test_can_get_discussion_list_with_false_is_being_watched()
    {
        $this->enableWatchersFeature();

        $response = $this->actingAs($this->getUser())
            ->get('forum/');

        $discussions = $response->viewData('discussions');

        $this->assertEquals(1, $discussions->count());

        $this->assertEquals($this->getDiscussion()->id, $discussions->first()->id);

        $this->assertTrue(array_key_exists('is_being_watched', $discussions->first()->attributesToArray()));
        $this->assertFalse($discussions->first()->is_being_watched);
    }

    public function test_can_get_discussion_list_with_full_is_being_watched()
    {
        $this->enableWatchersFeature();

        $this->getDiscussion()->watchers()->save($this->getUser());

        $response = $this->actingAs($this->getUser())
            ->get('forum/');

        $discussions = $response->viewData('discussions');

        $this->assertEquals(1, $discussions->count());

        $this->assertEquals($this->getDiscussion()->id, $discussions->first()->id);

        $this->assertTrue(array_key_exists('is_being_watched', $discussions->first()->attributesToArray()));
        $this->assertNotNull($discussions->first()->is_being_watched);
    }
}
