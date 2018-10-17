<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Discussion;
use Firefly\Group;
use Firefly\Http\Controllers\Controller;
use Firefly\Http\Requests\StoreDiscussionRequest;
use Firefly\Services\DiscussionService;
use Firefly\Services\PostService;

class DiscussionController extends Controller
{
    /**
     * Instance of the discussion service.
     *
     * @var \Firefly\Services\DiscussionService
     */
    public $discussionService;

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
    public function __construct(DiscussionService $discussionService, PostService $postService)
    {
        $this->discussionService = $discussionService;
        $this->postService = $postService;
    }

    /**
     * Store the new discussion.
     *
     * @param \Firefly\Http\Requests\StoreDiscussionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDiscussionRequest $request)
    {
        $group = Group::findOrFail($request->group_id);

        $this->authorize('create', Discussion::class);

        $discussion = $this->discussionService->make($request);

        $group->discussions()->save($discussion);

        $discussion->posts()->save(
            $this->postService->make($request)
        );

        return response()->json($discussion);
    }
}