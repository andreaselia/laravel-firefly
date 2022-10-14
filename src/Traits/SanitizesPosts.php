<?php

namespace Firefly\Traits;

use Firefly\Features;

trait SanitizesPosts
{
    /**
     * Returns sanitized content for Posts when using rich formatting and the wysiwyg editor.
     *
     * @param  array  $requestData
     * @return array
     */
    public function getSanitizedPostData(array $requestData)
    {
        $formatting = (isset($requestData['formatting'])) ? $requestData['formatting'] : 'plain';

        if (Features::enabled('wysiwyg') && $formatting === 'rich') {
            $notAllowedTags = ['script'];
            foreach ($notAllowedTags as $tag) {
                $requestData['content'] = preg_replace('/<\\/?'.$tag.'(.|\\s)*?>/i', '', $requestData['content']);
            }

            $prevUseErrors = libxml_use_internal_errors(true);
            $dom = new \DOMDocument();
            $dom->loadHTML('<root>' . $requestData['content'] . '</root>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $xpath = new \DOMXPath($dom);
            $selfClosingElements = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'];
            foreach( $xpath->query('//*[not(node())]') as $node ) {
                if(!in_array($node->localName, $selfClosingElements)) {
                    $node->parentNode->removeChild($node);
                }
            }
            $requestData['content'] = substr($dom->saveHTML(), 6, -8);
            libxml_use_internal_errors($prevUseErrors);
        }

        return $requestData;
    }
}
