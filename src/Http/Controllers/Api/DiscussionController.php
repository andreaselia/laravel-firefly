<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Discussion;
use Firefly\Group;
use Firefly\Http\Controllers\Controller;
use Firefly\Http\Requests\StoreDiscussionRequest;
use Firefly\Services\DiscussionService;

class DiscussionController extends Controller
{
    /**
     * Instance of the discussion service.
     *
     * @var \Firefly\Services\DiscussionService
     */
    public $discussionService;

    /**
     * Create a new instance of the controller.
     *
     * @param \Firefly\Services\DiscussionService $service
     */
    public function __construct(DiscussionService $discussionService)
    {
        $this->discussionService = $discussionService;
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

        $discussion = $this->discussionService->make($request, $group);

        return response()->json($discussion);
    }
}