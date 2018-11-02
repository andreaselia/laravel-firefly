<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Discussion;
use Firefly\Http\Controllers\Controller;
use Firefly\Http\Requests\StorePostRequest;
use Firefly\Http\Requests\UpdatePostRequest;
use Firefly\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store the new post.
     *
     * @param \Firefly\Http\Requests\StorePostRequest $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, Discussion $discussion)
    {
        $this->authorize('reply', $discussion);

        $user = $request->user();

        $post = $user->posts()->make(
            $request->only('content')
        );

        $discussion->posts()->save($post);

        return response()->json($post);
    }

    /**
     * Update the specified post.
     *
     * @param \Firefly\Http\Requests\UpdatePostRequest $request
     * @param \Firefly\Discussion $discussion
     * @param $slug
     * @param \Firefly\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Discussion $discussion, $slug, Post $post)
    {
        $this->authorize('update', $post);

        $post->update(
            $request->only('content')
        );

        return response()->json($post->fresh());
    }

    /**
     * Delete the specified post.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @param $slug
     * @param \Firefly\Post $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Discussion $discussion, $slug, Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json('OK');
    }
}
