<?php

namespace Firefly\Services;

use Illuminate\Http\Request;

class PostService
{
    /**
     * Make a new Post instance and attach it to the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function make(Request $request)
    {
        $post = $request->user()->posts()->make(
            $request->only('content')
        );

        return $post;
    }
}