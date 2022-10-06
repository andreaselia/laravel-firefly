<?php

namespace Firefly\Test\Feature;

use Carbon\Carbon;
use Firefly\Test\TestCase;

class CorrectPostTest extends TestCase
{
    public function test_post_was_marked_as_correct()
    {
        $this->enableDebug();

        $discussion = $this->getDiscussion();
        $post = $this->getPost();
        $this->assertFalse($post->is_correct);

        $response = $this->actingAs($this->getUser())
            ->post('forum/p/'.$post->id.'/correct');

        $post->refresh();

        $this->assertTrue($post->is_correct);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$post->discussion->uri);
    }

    public function test_post_was_unmarked_as_correct()
    {
        $this->enableDebug();

        $discussion = $this->getDiscussion();
        $post = $this->getPost();
        $post->update(['corrected_at' => Carbon::now()]);
        $this->assertTrue($post->is_correct);

        $response = $this->actingAs($this->getUser())
            ->delete('forum/p/'.$post->id.'/correct');

        $post->refresh();

        $this->assertFalse($post->is_correct);

        $response->assertRedirect();
        $response->assertLocation('forum/d/'.$post->discussion->uri);
    }
}
