<?php

namespace Firefly\Test\Feature;

use Firefly\Test\Fixtures\Discussion;
use Firefly\Test\Fixtures\Post;
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

    public function test_can_get_discussion_list_with_search()
    {
        $this->enableFeature('search');

        Post::truncate();
        Discussion::truncate();

        $discussion = Discussion::create([
            'user_id'  => $this->getUser()->id,
            'title'    => 'I want to search for content',
        ]);

        Post::create([
            'discussion_id' => $discussion->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Does Not Match',
        ]);

        $discussionTwo = Discussion::create([
            'user_id'  => $this->getUser()->id,
            'title'    => 'I do not like finding content',
        ]);

        Post::create([
            'discussion_id' => $discussionTwo->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Does Not Match',
        ]);

        $discussionThree = Discussion::create([
            'user_id'  => $this->getUser()->id,
            'title'    => 'I like finding content in posts',
        ]);

        Post::create([
            'discussion_id' => $discussionThree->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Should search for a match',
        ]);

        $response = $this->actingAs($this->getUser())
            ->get('forum/?search=search');

        $discussions = $response->viewData('discussions');

        $this->assertEquals(2, $discussions->count());

        $this->assertEquals($discussion->id, $discussions->first()->id);
        $this->assertEquals($discussionThree->id, $discussions->skip(1)->first()->id);
    }
}
