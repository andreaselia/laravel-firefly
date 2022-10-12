<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Http\Controllers\Controller;
use Firefly\Models\Discussion;
use Firefly\Services\DiscussionService;
use Illuminate\Http\Request;

class DiscussionWatchController extends Controller
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
     * @param  \Firefly\Services\DiscussionService  $service
     */
    public function __construct(DiscussionService $discussionService)
    {
        $this->middleware('auth');

        $this->discussionService = $discussionService;
    }

    /**
     * Watch the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Discussion $discussion)
    {
        $this->authorize('watch', $discussion);

        $this->discussionService->watch($discussion, $request->user());

        return response()->json('OK');
    }

    /**
     * Unwatch the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, Discussion $discussion)
    {
        $this->authorize('unwatch', $discussion);

        $this->discussionService->unwatch($discussion, $request->user());

        return response()->json('OK');
    }
}
