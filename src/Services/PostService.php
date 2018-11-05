<?php

namespace Firefly\Services;

use Firefly\Discussion;
use Illuminate\Http\Request;

class PostService
{
    /**
     * Make a new Post instance and attach it to the user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return mixed
     */
    public function make(Request $request, Discussion $discussion)
    {
        $user = $request->user();

        $post = $user->posts()->make($request->all());

        $discussion->posts()->save($post);

        return $discussion->refresh();
    }
}
