<?php

namespace Firefly\Http\Controllers;

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Discussion $discussion)
    {
        $this->authorize('watch', $discussion);

        $this->discussionService->watch($discussion, $request->user());

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Unwatch the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Discussion $discussion)
    {
        $this->authorize('unwatch', $discussion);

        $this->discussionService->unwatch($discussion, $request->user());

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }
}
