<?php

namespace Firefly\Http\Controllers;

use Firefly\Http\Requests\StoreGroupRequest;
use Firefly\Http\Requests\UpdateGroupRequest;
use Firefly\Models\Group;
use Firefly\Services\GroupService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Instance of the group service.
     *
     * @var \Firefly\Services\GroupService
     */
    public $groupService;

    /**
     * Create a new instance of the controller.
     *
     * @param  \Firefly\Services\GroupService  $service
     */
    public function __construct(GroupService $groupService)
    {
        $this->middleware('auth')->except(['index', 'show']);

        $this->groupService = $groupService;
    }

    /**
     * Show the groups index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $groups = Group::orderBy('name', 'asc')
            ->paginate(config('firefly.pagination.groups'));

        return view('firefly::groups.index')->withGroups($groups);
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
     * @param  \Firefly\Http\Requests\StoreGroupRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreGroupRequest $request)
    {
        $this->authorize('create', Group::class);

        $group = $this->groupService->make($request);

        return redirect()->route('firefly.group.show', $group);
    }

    /**
     * Show the discussions for the specified group.
     *
     * @param  \Firefly\Models\Group  $group
     * @return \Illuminate\View\View
     */
    public function show(Group $group)
    {
        $discussions = $group->discussions()
            ->orderBy('pinned_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(config('firefly.pagination.discussions'));

        return view('firefly::groups.show')->with(compact('group', 'discussions'));
    }

    /**
     * Show the form for editing a group.
     *
     * @param  \Firefly\Models\Group  $group
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
     * @param  \Firefly\Http\Requests\UpdateGroupRequest  $request
     * @param  \Firefly\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $this->authorize('update', $group);

        $group = $this->groupService->update($request, $group);

        return redirect()->route('firefly.group.show', $group);
    }

    /**
     * Delete the specified group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Group $group)
    {
        $this->authorize('delete', $group);

        $this->groupService->delete($group);

        return redirect()->route('firefly.index');
    }
}
