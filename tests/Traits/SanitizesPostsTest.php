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

    public function test_cleans_up_stray_tags_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $this->assertEquals(['formatting' => 'rich', 'content' => 'Text with trailing link'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => 'Text with trailing link<a href="http://laravel.com">']));
        $this->assertEquals(['formatting' => 'rich', 'content' => '<p>Text with leading tag</p>'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '<p>Text with leading tag']));
    }

    public function test_self_closing_tag_does_not_get_stripped_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $this->assertEquals(['formatting' => 'rich', 'content' => '<img src="http://example.com/image.jpg"><br><hr><br><img src="http://example.com/image2.jpg">'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '<img src="http://example.com/image.jpg"><br><hr><br/><img src="http://example.com/image2.jpg"/>']));
    }

    public function test_tags_get_formatted_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $this->assertEquals(['formatting' => 'rich', 'content' => '<p><b>Test</b></p><p>hi</p>'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '</p ><p><p><b >Test</p><p>hi</p >']));
    }

    public function test_emojis_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $this->assertEquals(['formatting' => 'rich', 'content' => '<p>&#127995;&zwj;&#127806;</p>'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '<p>🏻‍🌾</p>']));
    }
}
