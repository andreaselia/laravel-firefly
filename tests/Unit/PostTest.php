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
}
