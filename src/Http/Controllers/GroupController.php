<?php

namespace Firefly\Http\Controllers;

use Firefly\Group;
use Firefly\Http\Requests\StoreGroupRequest;
use Firefly\Http\Requests\UpdateGroupRequest;
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
     * @param \Firefly\Http\Requests\StoreGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreGroupRequest $request)
    {
        Group::create($request->all());

        return redirect()->route('firefly.forum.index');
    }

    /**
     * Show the discussions for the specified group.
     *
     * @param \Firefly\Group $group
     * @return \Illuminate\View\View
     */
    public function show(Group $group)
    {
        return view('firefly::groups.show')->withGroup($group)
            ->withDiscussions($group->discussions()->paginate());
    }

    /**
     * Update the specified group.
     *
     * @param \Firefly\Http\Requests\UpdateGroupRequest $request
     * @param \Firefly\Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $this->authorize('update', $group);

        $group->update($request->only('name'));

        return redirect()->route('firefly.group.show', $group->slug);
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
