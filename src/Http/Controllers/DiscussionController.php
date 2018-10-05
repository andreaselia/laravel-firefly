<?php

namespace Firefly\Http\Controllers;

use Firefly\Discussion;
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDiscussionRequest $request)
    {
        $discussion = $request->user()->discussions()->create($request->all());

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Show the specified discussion.
     *
     * @param Discussion $discussion
     * @return \Illuminate\View\View
     */
    public function show(Discussion $discussion)
    {
        return view('firefly::discussions.show')->withDiscussion($discussion);
    }

    /**
     * Store the new discussion.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDiscussionRequest $request, Discussion $discussion)
    {
        $discussion->update($request->all());

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Delete the specified discussion.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Discussion $discussion)
    {
        $discussion->delete();

        return redirect()->route('forum.index');
    }

    /**
     * Lock the specified discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(Request $request, Discussion $discussion)
    {
        $discussion->lock();

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Unlock the specified discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlock(Request $request, Discussion $discussion)
    {
        $discussion->unlock();

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Stick the specified discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stick(Request $request, Discussion $discussion)
    {
        $discussion->stick();

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Unstick the specified discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unstick(Request $request, Discussion $discussion)
    {
        $discussion->unstick();

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Hide the specified discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\JsonResponse
     */
    public function hide(Request $request, Discussion $discussion)
    {
        $discussion->hide();

        return response()->json($discussion);
    }

    /**
     * Unhide the specified discussion.
     *
     * @param Request $request
     * @param Discussion $discussion
     * @return \Illuminate\Http\JsonResponse
     */
    public function unhide(Request $request, Discussion $discussion)
    {
        $discussion->unhide();

        return response()->json($discussion);
    }
}
