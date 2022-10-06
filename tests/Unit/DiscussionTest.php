<?php

namespace Firefly\Test\Unit;

use Carbon\Carbon;
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
}
