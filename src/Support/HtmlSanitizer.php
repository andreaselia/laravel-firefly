<?php

namespace Firefly\Support;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlSanitizer
{
    /**
     * The tags and attributes that the Quill editor produces.
     *
     * @var string
     */
    const ALLOWED_HTML = 'p,br,strong,b,em,i,u,s,ol,ul,li[class],a[href|target]';

    /** @var \HTMLPurifier[] */
    protected static $purifiers = [];

    /**
     * Remove anything from the given HTML that isn't allowed.
     *
     * @param  string|null  $html
     * @return string
     */
    public static function purify(?string $html): string
    {
        return static::purifier()->purify((string) $html);
    }

    /**
     * Get the configured purifier instance.
     *
     * @return \HTMLPurifier
     */
    protected static function purifier(): HTMLPurifier
    {
        $allowed = config('firefly.features.wysiwyg.allowed_html') ?: static::ALLOWED_HTML;

        if (isset(static::$purifiers[$allowed])) {
            return static::$purifiers[$allowed];
        }

        $config = HTMLPurifier_Config::createDefault();

        // Don't write the definition cache into the vendor directory
        $config->set('Cache.DefinitionImpl', null);
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $config->set('HTML.Allowed', $allowed);
        $config->set('Attr.AllowedClasses', array_map(fn ($level) => 'ql-indent-'.$level, range(1, 8)));
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
        $config->set('AutoFormat.RemoveEmpty', true);

        // Store emojis and other non-ASCII characters as HTML entities
        $config->set('Core.EscapeNonASCIICharacters', true);

        return static::$purifiers[$allowed] = new HTMLPurifier($config);
    }
}
