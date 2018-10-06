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
        $groups = Group::all();
        $discussions = Discussion::paginate();

        return view('firefly::index')->with(compact('groups', 'discussions'));
    }
}
