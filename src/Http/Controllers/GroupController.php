<?php

namespace Firefly\Http\Controllers;

use Firefly\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Show the groups index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('firefly::groups.index')->withGroups(Group::paginate());
    }

    /**
     * Show the form for creating a new group.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store the new group.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Group::create($request->all());

        return redirect()->back();
    }

    /**
     * Show the discussions for the specified group.
     *
     * @return \Illuminate\View\View
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Update the specified group.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Group $group)
    {
        $group->update($request->all());

        return redirect()->back();
    }

    /**
     * Delete the specified group.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Group $group)
    {
        $group->delete();

        return redirect()->back();
    }
}
