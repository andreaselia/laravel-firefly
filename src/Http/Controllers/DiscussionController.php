<?php

namespace Firefly\Http\Controllers;

use Firefly\Discussion;
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
        //
    }

    /**
     * Store the new discussion.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $discussion = $request->user()->discussions()->create($request->all());

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Show the specified discussion.
     *
     * @param Discussion $discussion
     */
    public function show(Discussion $discussion)
    {
        //
    }

    /**
     * Store the new discussion.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Discussion $discussion)
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
}