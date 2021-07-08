<?php

namespace Firefly\Test\Feature;

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
            ->post('forum/d/' . $discussion->uri . '/p/' . $post->id . '/correct');

        $post->refresh();

        $this->assertTrue($post->is_correct);

        $response->assertRedirect();
        $response->assertLocation('forum/d/' . $post->discussion->uri);
    }

    public function test_post_was_unmarked_as_correct()
    {
        $this->enableDebug();

        $discussion = $this->getDiscussion();
        $post = $this->getPost();
        $post->update(['is_correct' => true]);
        $this->assertTrue($post->is_correct);

        $response = $this->actingAs($this->getUser())
            ->delete('forum/d/' . $discussion->uri . '/p/' . $post->id . '/correct');

        $post->refresh();

        $this->assertFalse($post->is_correct);

        $response->assertRedirect();
        $response->assertLocation('forum/d/' . $post->discussion->uri);
    }
}
