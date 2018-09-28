<?php

namespace Firefly\Http\Controllers;

class ForumController extends Controller
{
    /**
     * Show the forum index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('firefly::index');
    }
}
