<?php

namespace Firefly\Http\Controllers;

use Firefly\Models\Discussion;
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
        $this->middleware('auth');

        $this->postService = $postService;
    }

    /**
     * Mark the post as "correct"
     *
     * @param \Illuminate\Http\Request   $request
     * @param \Firefly\Models\Discussion $discussion
     * @param $slug
     * @param \Firefly\Models\Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Discussion $discussion, $slug, Post $post)
    {
        $this->authorize('mark', $post);

        $this->postService->setCorrect($post);

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Unmark the post as correct
     *
     * @param \Illuminate\Http\Request   $request
     * @param \Firefly\Models\Discussion $discussion
     * @param $slug
     * @param \Firefly\Models\Discussion $discussion
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Discussion $discussion, $slug, Post $post)
    {
        $this->authorize('unmark', $post);

        $this->postService->unsetCorrect($post);

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }
}
