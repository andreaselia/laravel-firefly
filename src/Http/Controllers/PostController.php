<?php

namespace Firefly\Http\Controllers;

use Firefly\Discussion;
use Firefly\Http\Requests\StorePostRequest;
use Firefly\Http\Requests\UpdatePostRequest;
use Firefly\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store the new post.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, Discussion $discussion)
    {
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
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @param $slug
     * @param \Firefly\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Discussion $discussion, $slug, Post $post)
    {
        $post->update(
            $request->only('content')
        );

        return response()->json($post);
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
        $post->delete();

        return response()->json($post);
    }

    /**
     * Hide the specified post.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function hide(Request $request, Post $post)
    {
        $post->hide();

        return response()->json($post);
    }

    /**
     * Unhide the specified post.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function unhide(Request $request, Post $post)
    {
        $post->unhide();

        return response()->json($post);
    }
}
