<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Group;
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
     * Store the new group.
     *
     * @param \Firefly\Http\Requests\StoreGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        $group = $this->groupService->make($request);

        return response()->json($group);
    }

    /**
     * Update the specified group.
     *
     * @param \Firefly\Http\Requests\UpdateGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
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
        $this->groupService->delete($group);

        return response()->json('OK');
    }
}
