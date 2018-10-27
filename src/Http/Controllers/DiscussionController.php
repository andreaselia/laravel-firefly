<?php

namespace Firefly\Http\Controllers;

use Firefly\Discussion;
use Firefly\Group;
use Firefly\Http\Requests\StoreDiscussionRequest;
use Firefly\Http\Requests\UpdateDiscussionRequest;
use Firefly\Services\DiscussionService;
use Illuminate\Http\RedirectResponse;
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
     * Show the form for creating a new discussion.
     *
     * @param \Firefly\Group $group
     * @return \Illuminate\View\View
     */
    public function create(Group $group)
    {
        return view('firefly::discussions.create')->withGroup($group);
    }

    /**
     * Store the new discussion.
     *
     * @param \Firefly\Http\Requests\StoreDiscussionRequest $request
     * @param \Firefly\Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDiscussionRequest $request, Group $group)
    {
        $this->authorize('create', Discussion::class);

        $discussion = $this->discussionService->make($request, $group);

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Show the specified discussion.
     *
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\View\View
     */
    public function show(Discussion $discussion)
    {
        return view('firefly::discussions.show')->withDiscussion($discussion)
            ->withPosts($discussion->posts()->paginate());
    }

    /**
     * Show the form for editing a discussion.
     *
     * @param \Firefly\Group $group
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\View\View
     */
    public function edit(Group $group, Discussion $discussion)
    {
        return view('firefly::discussions.edit')->withGroup($group)
            ->withDiscussion($discussion);
    }

    /**
     * Update the specified discussion.
     *
     * @param \Firefly\Http\Requests\UpdateDiscussionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDiscussionRequest $request, Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        $discussion->update($request->all());

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Delete the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Discussion $discussion)
    {
        $this->authorize('delete', $discussion);

        $discussion->delete();

        return redirect()->route('firefly.forum.index');
    }

    /**
     * Lock the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(Request $request, Discussion $discussion)
    {
        $this->authorize('lock', $discussion);

        $discussion->lock();

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Unlock the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlock(Request $request, Discussion $discussion)
    {
        $this->authorize('unlock', $discussion);

        $discussion->unlock();

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Stick the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stick(Request $request, Discussion $discussion)
    {
        $this->authorize('stick', $discussion);

        $discussion->stick();

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Unstick the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unstick(Request $request, Discussion $discussion)
    {
        $this->authorize('unstick', $discussion);

        $discussion->unstick();

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Hide the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\JsonResponse
     */
    public function hide(Request $request, Discussion $discussion)
    {
        $this->authorize('hide', $discussion);

        $discussion->hide();

        return response()->json($discussion);
    }

    /**
     * Unhide the specified discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\JsonResponse
     */
    public function unhide(Request $request, Discussion $discussion)
    {
        $this->authorize('hide', $discussion);

        $discussion->unhide();

        return response()->json($discussion);
    }
}
