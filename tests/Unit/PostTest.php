<?php

namespace Firefly\Test\Unit;

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
}
