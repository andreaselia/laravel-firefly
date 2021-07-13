<?php

namespace Firefly\Traits;

use Firefly\Features;

trait SanitizesPosts
{
    /**
     * Returns sanitized content for Posts when using rich formatting and the wysiwyg editor.
     *
     * @param array $requestData
     *
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

            return $requestData;
        }

        return $requestData;
    }
}
