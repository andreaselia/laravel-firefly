<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Models\Group;
use Firefly\Http\Controllers\Controller;
use Firefly\Http\Requests\StoreGroupRequest;
use Firefly\Http\Requests\UpdateGroupRequest;
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
     * @param \Firefly\Services\GroupService $service
     */
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }


    /**
     * Show the groups index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::orderBy('name', 'asc')
            ->paginate(config('firefly.pagination.groups'));

        return $groups;
    }

    /**
     * Store the new group.
     *
     * @param \Firefly\Http\Requests\StoreGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        $this->authorize('create', Group::class);

        $group = $this->groupService->make($request);

        return response()->json($group);
    }

    /**
     * Show the discussions for the specified group.
     *
     * @param \Firefly\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $discussions = $group->discussions()
            ->orderBy('pinned_at', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(config('firefly.pagination.discussions'));

        return compact('group', 'discussions');
    }

    /**
     * Update the specified group.
     *
     * @param \Firefly\Http\Requests\UpdateGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        $this->authorize('update', $group);

        $group = $this->groupService->update($request, $group);

        return response()->json($group);
    }

    /**
     * Delete the specified group.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Group $group)
    {
        $this->authorize('delete', $group);

        $group->delete();

        return response()->json('OK');
    }
}
