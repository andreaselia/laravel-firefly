<?php

namespace Firefly\Test\Unit;

use Carbon\Carbon;
use Firefly\Test\Fixtures\Discussion;
use Firefly\Test\Fixtures\Post;
use Firefly\Test\TestCase;

class DiscussionTest extends TestCase
{
    public function test_can_get_initial_post()
    {
        $discussion = $this->getDiscussion();
        $post = $this->getPost();
        $post->update(['is_initial_post' => 1]);

        $secondPost = Post::create([
            'discussion_id' => $discussion->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Lorem ipsum',
        ]);

        $this->assertNotNull($discussion->initialPost);
        $this->assertEquals($post->id, $discussion->initialPost->id);
        $this->assertNotEquals($secondPost->id, $discussion->initialPost->id);
    }

    public function test_can_get_correct_post()
    {
        $discussion = $this->getDiscussion();
        $post = $this->getPost();
        $secondPost = Post::create([
            'discussion_id' => $discussion->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Lorem ipsum',
            'corrected_at'  => Carbon::now(),
        ]);

        $this->assertNotNull($discussion->correctPost);
        $this->assertEquals($secondPost->id, $discussion->correctPost->id);
    }

    public function test_can_search_discussion()
    {
        $this->enableFeature('search');

        Post::truncate();
        Discussion::truncate();

        $discussion = Discussion::create([
            'user_id'  => $this->getUser()->id,
            'title'    => 'I want to search for content',
            'group_id' => $this->getGroup()->id,
        ]);

        Post::create([
            'discussion_id' => $discussion->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Does Not Match',
        ]);

        $discussionTwo = Discussion::create([
            'user_id'  => $this->getUser()->id,
            'title'    => 'I do not like finding content',
            'group_id' => $this->getGroup()->id,
        ]);

        Post::create([
            'discussion_id' => $discussionTwo->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Does Not Match',
        ]);

        $discussionThree = Discussion::create([
            'user_id'  => $this->getUser()->id,
            'title'    => 'I like finding content in posts',
            'group_id' => $this->getGroup()->id,
        ]);

        Post::create([
            'discussion_id' => $discussionThree->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Should search for a match',
        ]);

        $this->assertEquals(3, Discussion::count());
        $this->assertEquals(2, Discussion::withSearch('search')->count());

        $this->assertEquals($discussion->id, Discussion::withSearch('search')->first()->id);
        $this->assertEquals($discussionThree->id, Discussion::withSearch('search')->skip(1)->first()->id);
    }
}
