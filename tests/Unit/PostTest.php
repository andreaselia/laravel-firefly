<?php

namespace Firefly\Test\Unit;

use Firefly\Test\Fixtures\Post;
use Firefly\Test\TestCase;

class PostTest extends TestCase
{
    public function test_can_get_is_richly_formatted()
    {
        $post = $this->getPost();
        $this->assertFalse($post->isRichlyFormatted);
        $this->assertFalse($post->is_richly_formatted);

        $post->formatting = 'plain';
        $this->assertFalse($post->isRichlyFormatted);
        $this->assertFalse($post->is_richly_formatted);

        $post->formatting = 'rich';
        $this->assertTrue($post->isRichlyFormatted);
        $this->assertTrue($post->is_richly_formatted);
    }

    public function test_can_get_formatted_content()
    {
        $post = $this->getPost();
        $post->formatting = 'plain';
        $post->content = "This is\na plain text post";
        $this->assertEquals("This is<br />\na plain text post", $post->formatted_content);
        $this->assertEquals("This is<br />\na plain text post", $post->formattedContent);

        $post->formatting = 'rich';
        $post->content = '<p>This is<br>a rich text post</p>';
        $this->assertEquals('<p>This is<br>a rich text post</p>', $post->formatted_content);
        $this->assertEquals('<p>This is<br>a rich text post</p>', $post->formattedContent);
    }

    public function test_can_get_is_initial_post()
    {
        $post = $this->getPost();
        $post->update(['is_initial_post' => 1]);

        $this->assertTrue($post->is_initial_post);
    }

    public function test_can_search_posts()
    {
        $this->enableFeature('search');

        Post::truncate();

        Post::create([
            'discussion_id' => $this->getDiscussion()->id,
            'user_id' => $this->getUser()->id,
            'content' => 'Match for iPhone search',
        ]);

        Post::create([
            'discussion_id' => $this->getDiscussion()->id,
            'user_id' => $this->getUser()->id,
            'content' => 'No match for i Phone search',
        ]);

        Post::create([
            'discussion_id' => $this->getDiscussion()->id,
            'user_id' => $this->getUser()->id,
            'content' => 'Another match for iPhone search',
        ]);

        $this->assertEquals(3, Post::count());
        $this->assertEquals(2, Post::withSearch('iphone')->count());
        $this->assertEquals(1, Post::withSearch('i phone')->count());
    }
}
