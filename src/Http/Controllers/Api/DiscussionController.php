<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Http\Controllers\Controller;
use Firefly\Http\Requests\StoreDiscussionRequest;
use Firefly\Http\Requests\UpdateDiscussionRequest;
use Firefly\Models\Discussion;
use Firefly\Models\Group;
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
     * @param  \Firefly\Services\DiscussionService  $service
     */
    public function __construct(DiscussionService $discussionService)
    {
        $this->discussionService = $discussionService;
    }

    /**
     * Show the discussions index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();

        $discussions = Discussion::orderBy('created_at', 'desc')
            ->paginate(config('firefly.pagination.discussions'));

        return compact('groups', 'discussions');
    }

    /**
     * Store the new discussion.
     *
     * @param  \Firefly\Http\Requests\StoreDiscussionRequest  $request
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
     * Show the specified discussion.
     *
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function show(Discussion $discussion)
    {
        return response()->json([
            'discussion' => $discussion,
            'posts' => $discussion->posts()->paginate(config('firefly.pagination.posts')),
        ]);
    }

    /**
     * Update the specified discussion.
     *
     * @param  \Firefly\Http\Requests\UpdateDiscussionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiscussionRequest $request, Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        $discussion = $this->discussionService->update($request, $discussion);

        return response()->json($discussion->fresh());
    }

    /**
     * Delete the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Discussion $discussion)
    {
        $this->authorize('delete', $discussion);

        $this->discussionService->delete($discussion);

        return response()->json('OK');
    }

    /**
     * Lock the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function lock(Request $request, Discussion $discussion)
    {
        $this->authorize('lock', $discussion);

        $this->discussionService->updateState($discussion, 'lock');

        return response()->json('OK');
    }

    /**
     * Unlock the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function unlock(Request $request, Discussion $discussion)
    {
        $this->authorize('unlock', $discussion);

        $this->discussionService->updateState($discussion, 'unlock');

        return response()->json('OK');
    }

    /**
     * Pin the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function pin(Request $request, Discussion $discussion)
    {
        $this->authorize('pin', $discussion);

        $this->discussionService->updateState($discussion, 'pin');

        return response()->json('OK');
    }

    /**
     * Unpin the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function unpin(Request $request, Discussion $discussion)
    {
        $this->authorize('unpin', $discussion);

        $this->discussionService->updateState($discussion, 'unpin');

        return response()->json('OK');
    }
}
