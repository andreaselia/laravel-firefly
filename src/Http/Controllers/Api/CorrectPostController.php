<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Http\Controllers\Controller;
use Firefly\Models\Post;
use Firefly\Services\PostService;
use Illuminate\Http\Request;

class CorrectPostController extends Controller
{
    /**
     * Instance of the post service.
     *
     * @var \Firefly\Services\PostService
     */
    public $postService;

    /**
     * Create a new instance of the controller.
     *
     * @param \Firefly\Services\DiscussionService $service
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Mark the post as "correct".
     *
     * @param \Illuminate\Http\Request   $request
     * @param \Firefly\Models\Discussion $discussion
     * @param $slug
     * @param \Firefly\Models\Post $post
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Post $post)
    {
        $this->authorize('mark', $post);

        $post = $this->postService->setCorrect($post);

        return response()->json($post);
    }

    /**
     * Unmark the post as correct.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \Firefly\Models\Discussion $discussion
     * @param $slug
     * @param \Firefly\Models\Discussion $discussion
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, Post $post)
    {
        $this->authorize('unmark', $post);

        $post = $this->postService->unsetCorrect($post);

        return response()->json($post);
    }
}
