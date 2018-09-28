<?php

namespace Firefly\Http\Controllers;

use Firefly\Discussion;
use Illuminate\Http\Request;

class PostController extends Controller
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
    public function store(Request $request, Discussion $discussion)
    {
        $user = $request->user();

        $post = $user->posts()->make($request->all());

        $discussion->posts()->save($post);

        return redirect()->route('discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Store the new discussion.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Discussion $discussion)
    {
        //
    }

    /**
     * Delete the specified discussion.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Discussion $discussion)
    {
        //
    }
}