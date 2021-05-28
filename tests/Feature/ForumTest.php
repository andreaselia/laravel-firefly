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

    /**
     * @define-env usesWatchers
     */
    public function test_can_get_discussion_list_with_empty_is_being_watched()
    {
        $response = $this->actingAs($this->getUser())
            ->get('forum/');

        $discussions = $response->viewData('discussions');

        $this->assertEquals(1, $discussions->count());

        $this->assertEquals($this->getDiscussion()->id, $discussions->first()->id);

        $this->assertTrue(array_key_exists('is_being_watched', $discussions->first()->attributesToArray()));
        $this->assertNull($discussions->first()->is_being_watched);
    }

    /**
     * @define-env usesWatchers
     */
    public function test_can_get_discussion_list_with_full_is_being_watched()
    {
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
