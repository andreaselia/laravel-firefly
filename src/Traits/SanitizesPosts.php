<?php

namespace Firefly\Traits;

use Firefly\Features;
use Firefly\Support\HtmlSanitizer;

trait SanitizesPosts
{
    public function getSanitizedPostData(array $requestData): array
    {
        $formatting = $requestData['formatting'] ?? 'plain';

        // Rich text can only be submitted while the wysiwyg editor is enabled
        if (! Features::enabled('wysiwyg')) {
            $formatting = 'plain';
        }

        if (array_key_exists('formatting', $requestData)) {
            $requestData['formatting'] = $formatting;
        }

        if ($formatting === 'rich') {
            $requestData['content'] = HtmlSanitizer::purify($requestData['content'] ?? '');
        }

        return $requestData;
    }
}
