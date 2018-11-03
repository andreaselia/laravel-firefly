<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Discussion;
use Firefly\Http\Controllers\Controller;
use Firefly\Http\Requests\StorePostRequest;
use Firefly\Http\Requests\UpdatePostRequest;
use Firefly\Post;
use Illuminate\Http\Request;
use Firefly\Services\PostService;

class PostController extends Controller
{
    /**
     * Instance of the discussion service.
     *
     * @var \Firefly\Services\PostService
     */
    public $postService;

    /**
     * Create a new instance of the controller.
     *
     * @param \Firefly\Services\PostService $service
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

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

        $post = $this->postService->make($request, $discussion);

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

        $post->update($request->all());

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
