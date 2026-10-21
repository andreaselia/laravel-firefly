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

    public function test_forces_plain_text_with_wyswig_disabled_and_rich_text_submitted()
    {
        $this->assertFalse(config('firefly.features.wysiwyg.enabled'));

        $this->assertEquals(['formatting' => 'plain', 'content' => '<img src=x onerror=alert(1)>'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '<img src=x onerror=alert(1)>']));
    }

    public function test_strips_script_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);
        $this->assertTrue(config('firefly.features.wysiwyg.enabled'));

        $this->assertEquals(['formatting' => 'rich', 'content' => 'rich text content, '], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => 'rich text content, <script> alert("Hi!"); </script>']));
    }

    public function test_neutralises_xss_payloads_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $payloads = [
            '<img src=x onerror=alert(1)>' => '',
            '<p onclick="alert(1)" onmouseover="alert(1)">Hi</p>' => '<p>Hi</p>',
            '<a href="javascript:alert(1)">Link</a>' => '<a>Link</a>',
            '<a href="JaVaScRiPt:alert(1)">Link</a>' => '<a>Link</a>',
            '<a href=" javascript:alert(1)">Link</a>' => '<a>Link</a>',
            '<a href="data:text/html;base64,PHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg==">Link</a>' => '<a>Link</a>',
            '<p>Hi</p><script>alert(1)</script>' => '<p>Hi</p>',
            '<p>Hi</p><iframe src="https://example.com"></iframe>' => '<p>Hi</p>',
            '<p>Hi</p><style>body { display: none; }</style>' => '<p>Hi</p>',
            '<p style="background: url(javascript:alert(1))">Hi</p>' => '<p>Hi</p>',
            '<svg onload=alert(1)><p>Hi</p></svg>' => '<p>Hi</p>',
        ];

        foreach ($payloads as $payload => $expected) {
            $this->assertEquals(['formatting' => 'rich', 'content' => $expected], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => $payload]), $payload);
        }
    }

    public function test_quill_markup_survives_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $content = '<p><strong>Bold</strong> <b>bold</b> <em>italic</em> <i>italic</i> <u>underline</u> <s>strike</s></p>'
            .'<ol><li>One</li><li class="ql-indent-1">Nested</li></ol><ul><li>Bullet</li></ul><p><br></p>'
            .'<p><a href="mailto:hello@example.com">Mail</a> <a href="http://example.com">Http</a></p>';

        $this->assertEquals(['formatting' => 'rich', 'content' => $content], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => $content]));

        // Quill adds rel and target to links, the purifier keeps them (in its own attribute order)
        $this->assertEquals(
            ['formatting' => 'rich', 'content' => '<p><a href="https://laravel.com" target="_blank" rel="noreferrer noopener">Laravel</a></p>'],
            $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '<p><a href="https://laravel.com" rel="noopener noreferrer" target="_blank">Laravel</a></p>'])
        );

        // Unknown classes are removed
        $this->assertEquals(['formatting' => 'rich', 'content' => '<ul><li>One</li></ul>'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '<ul><li class="evil">One</li></ul>']));
    }

    public function test_allowed_html_can_be_extended_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $content = '<h1>Title</h1><p>Body</p>';

        $this->assertEquals(['formatting' => 'rich', 'content' => 'Title<p>Body</p>'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => $content]));

        $this->app->config->set('firefly.features.wysiwyg.allowed_html', 'h1,p');

        $this->assertEquals(['formatting' => 'rich', 'content' => $content], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => $content]));
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

        // Images and horizontal rules aren't produced by the editor toolbar, so they get removed
        $this->assertEquals(['formatting' => 'rich', 'content' => '<br><br>'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '<img src="http://example.com/image.jpg"><br><hr><br/><img src="http://example.com/image2.jpg"/>']));
    }

    public function test_tags_get_formatted_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $this->assertEquals(['formatting' => 'rich', 'content' => '<p><b>Test</b></p><p>hi</p>'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '</p ><p><p><b >Test</p><p>hi</p >']));
    }

    public function test_emojis_with_wyswig_enabled_and_rich_text_submitted()
    {
        $this->app->config->set('firefly.features.wysiwyg.enabled', true);

        $this->assertEquals(['formatting' => 'rich', 'content' => '<p>&#127995;&#8205;&#127806;</p>'], $this->testClass->getSanitizedPostData(['formatting' => 'rich', 'content' => '<p>🏻‍🌾</p>']));
    }
}
