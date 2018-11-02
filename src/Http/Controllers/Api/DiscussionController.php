<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Discussion;
use Firefly\Group;
use Firefly\Http\Controllers\Controller;
use Firefly\Http\Requests\UpdateDiscussionRequest;
use Firefly\Http\Requests\StoreDiscussionRequest;
use Firefly\Services\DiscussionService;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiscussionRequest $request)
    {
        $this->authorize('create', Discussion::class);

        $group = Group::findOrFail($request->group_id);

        $discussion = $this->discussionService->make($request, $group);

        return response()->json($discussion);
    }

    /**
     * Update the specified discussion.
     *
     * @param \Firefly\Http\Requests\UpdateDiscussionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiscussionRequest $request, Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        $discussion->update($request->all());

        return response()->json($discussion->fresh());
    }

    /**
     * Delete the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Discussion $discussion)
    {
        $this->authorize('delete', $discussion);

        $discussion->delete();

        return response()->json('OK');
    }

    /**
     * Lock the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function lock(Request $request, Discussion $discussion)
    {
        $this->authorize('lock', $discussion);

        $discussion->lock();

        return response()->json('OK');
    }

    /**
     * Unlock the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function unlock(Request $request, Discussion $discussion)
    {
        $this->authorize('unlock', $discussion);

        $discussion->unlock();

        return response()->json('OK');
    }
}
