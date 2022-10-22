<?php

namespace Firefly\Http\Controllers;

use Firefly\Models\Discussion;
use Firefly\Models\Group;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Show the forum index.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $groups = Group::all();

        $discussions = Discussion::query()
            ->withIsBeingWatched($request->user())
            ->withIsAnswered()
            ->withSearch($request->get('search'))
            ->orderBy('created_at', 'desc')
            ->paginate(config('firefly.pagination.discussions'));

        return view('firefly::index')
            ->with(compact('groups', 'discussions'))
            ->withSearch($request->get('search'));
    }
}
