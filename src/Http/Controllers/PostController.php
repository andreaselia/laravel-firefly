<?php

namespace Firefly\Http\Controllers;

use Firefly\Discussion;
use Firefly\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Show the form for creating a new discussion.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store the new discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Discussion $discussion)
    {
        $user = $request->user();

        $post = $user->posts()->make(
            $request->only('content')
        );

        $discussion->posts()->save($post);

        return response()->json($post);
    }

    /**
     * Store the new discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @param $slug
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discussion $discussion, $slug, Post $post)
    {
        $post->update(
            $request->only('content')
        );

        return response()->json($post);
    }

    /**
     * Delete the specified discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @param $slug
     * @param Post $post
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
     * @param Request $request
     * @param Post $post
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
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function unhide(Request $request, Post $post)
    {
        $post->unhide();

        return response()->json($post);
    }
}
