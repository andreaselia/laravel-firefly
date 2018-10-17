<?php

namespace Firefly\Services;

use Illuminate\Http\Request;

class DiscussionService
{
    /**
     * Make a new Discussion instance and attach it to the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function make(Request $request)
    {
        $discussion = $request->user()->discussions()->make(
            $request->only('title')
        );

        return $discussion;
    }
}