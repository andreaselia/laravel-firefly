<?php

namespace Firefly\Test\Traits;

use Firefly\Test\TestCase;
use Firefly\Traits\SanitizesPosts;

class SanitizesPostsTest extends TestCase
{
    private $testClass;

    public function setUp(): void
    {
        parent::setUp();

        $this->testClass = new class
        {
            use SanitizesPosts;
        };
    }

    public function test_does_not_strip_tags_with_wyswig_disabled()
    {
        $this->assertFalse(config('firefly.features.wysiwyg.enabled'));

        $this->assertEquals(['content' => 'plain text content, <script> alert("Hi!"); </script>'], $this->testClass->getSanitizedPostData(['content' => 'plain text content, <script> alert("Hi!"); </script>']));
    }

    public function test_does_not_strip_tags_with_wyswig_enabled_and_plain_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);
        $this->assertTrue(config('firefly.features.wysiwyg.enabled'));

        $this->assertEquals(['content' => 'plain text content, <script> alert("Hi!"); </script>'], $this->testClass->getSanitizedPostData(['content' => 'plain text content, <script> alert("Hi!"); </script>']));

        $this->assertEquals(['formatting' => 'plain', 'content' => 'plain text content, <script> alert("Hi!"); </script>'], $this->testClass->getSanitizedPostData(['formatting' => 'plain', 'content' => 'plain text content, <script> alert("Hi!"); </script>']));
    }

    public function test_does_not_strip_tags_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);
        $this->assertTrue(config('firefly.features.wysiwyg.enabled'));

        $this->assertEquals(['formatting' => 'rich', 'content' => 'rich text content,  alert("Hi!"); '], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => 'rich text content, <script> alert("Hi!"); </script>']));
    }
}
