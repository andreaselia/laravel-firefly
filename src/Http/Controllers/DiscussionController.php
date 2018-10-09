<?php

namespace Firefly\Http\Controllers;

use Firefly\Discussion;
use Firefly\Group;
use Firefly\Http\Requests\StoreDiscussionRequest;
use Firefly\Http\Requests\UpdateDiscussionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    /**
     * Show the form for creating a new discussion.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('firefly::discussions.create');
    }

    /**
     * Store the new discussion.
     *
     * @param \Firefly\Http\Requests\StoreDiscussionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDiscussionRequest $request, Group $group)
    {
        $this->authorize('create', Discussion::class);

        $user = $request->user();

        // Make the discussion under the user and save it to the group
        $discussion = $user->discussions()->make(
            $request->only('title')
        );

        $group->discussions()->save($discussion);

        // Make the post under the user and save it to the discussion
        $post = $user->posts()->make(
            $request->only('content')
        );

        $discussion->posts()->save($post);

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
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
     * Update the new discussion.
     *
     * @param \Firefly\Http\Requests\UpdateDiscussionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDiscussionRequest $request, Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        $discussion->update($request->all());

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
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

        return redirect()->route('forum.index');
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

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
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

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
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

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
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

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
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
