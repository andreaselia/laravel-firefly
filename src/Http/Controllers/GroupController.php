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
        return view('firefly::groups.create');
    }

    /**
     * Store the new group.
     *
     * @param \Firefly\Http\Requests\StoreGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreGroupRequest $request)
    {
        $group = Group::create($request->except('is_private') + [
            'is_private' => $request->has('is_private'),
        ]);

        return redirect()->route('firefly.group.show', $group);
    }

    /**
     * Show the discussions for the specified group.
     *
     * @param \Firefly\Group $group
     * @return \Illuminate\View\View
     */
    public function show(Group $group)
    {
        $discussions = $group->discussions()
            ->orderBy('created_at', 'desc')
            ->orderBy('pinned_at')
            ->paginate(config('firefly.pagination.discussions'));

        return view('firefly::groups.show')->with(compact('group', 'discussions'));
    }

    /**
     * Show the form for editing a group.
     *
     * @param \Firefly\Group $group
     * @return \Illuminate\View\View
     */
    public function edit(Group $group)
    {
        $this->authorize('update', $group);

        return view('firefly::groups.edit')->withGroup($group);
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

        $group->update($request->except('is_private') + [
            'is_private' => $request->has('is_private'),
        ]);

        return redirect()->route('firefly.group.show', $group);
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

        return redirect()->route('firefly.index');
    }
}
