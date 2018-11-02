<?php

namespace Firefly\Http\Controllers;

use Firefly\Group;
use Firefly\Discussion;

class ForumController extends Controller
{
    /**
     * Show the forum index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('firefly::index')->withGroups(Group::all())
            ->withDiscussions(Discussion::paginate(config('firefly.pagination.discussions')));
    }
}
