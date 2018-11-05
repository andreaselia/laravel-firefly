<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Group;
use Firefly\Http\Controllers\Controller;
use Firefly\Http\Requests\StoreGroupRequest;
use Firefly\Http\Requests\UpdateGroupRequest;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Store the new group.
     *
     * @param \Firefly\Http\Requests\StoreGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        $this->authorize('create', Group::class);

        $group = Group::create($request->except('is_private') + [
            'is_private' => $request->has('is_private'),
        ]);

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
        $this->authorize('update', $group);

        $group->update($request->except('is_private') + [
            'is_private' => $request->has('is_private'),
        ]);

        return response()->json($group->fresh());
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
