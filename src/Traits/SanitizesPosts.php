<?php

namespace Firefly\Traits;

use Firefly\Features;

trait SanitizesPosts
{
    public function getSanitizedPostData(array $requestData): array
    {
        $formatting = $requestData['formatting'] ?? 'plain';

        if (Features::enabled('wysiwyg') && $formatting === 'rich') {
            $requestData['content'] = $this->sanitizeContent($requestData['content']);

            $requestData['content'] = $this->convertToHtmlEntities($requestData['content']);

            $requestData['content'] = $this->removeEmptyTags($requestData['content']);

            $requestData['content'] = $this->removeRootTag($requestData['content']);
        }

        return $requestData;
    }

    private function sanitizeContent(string $content): string
    {
        $notAllowedTags = ['script'];
        foreach ($notAllowedTags as $tag) {
            $content = preg_replace('/<\\/?'.$tag.'(.|\\s)*?>/i', '', $content);
        }
        return $content;
    }

    private function convertToHtmlEntities(string $content): string
    {
        return mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
    }

    private function removeEmptyTags(string $content): string
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($dom);
        $selfClosingElements = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'];
        foreach ($xpath->query('//*[not(node())]') as $node) {
            if (! in_array($node->localName, $selfClosingElements)) {
                $node->parentNode->removeChild($node);
            }
        }
        return substr($dom->saveHTML(), 6, -8);
    }

    private function removeRootTag(string $content): string
    {
        return str_replace(['<root>', '</root>'], '', $content);
    }
}
