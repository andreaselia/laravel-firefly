<?php

namespace Firefly\Services;

use Firefly\Group;
use Illuminate\Http\Request;

class GroupService
{
    /**
     * Make a new group.
     * 
     * @param Request $request
     * @return mixed
     */
    public function make(Request $request)
    {
        $this->authorize('create', Group::class);

        $request->merge(['is_private' => $request->has('is_private')]);

        return Group::create($request->all());
    }

    /**
     * Update the specified group.
     * 
     * @param Request $request
     * @param Group $group
     * @return bool
     */
    public function update(Request $request, Group $group)
    {
        $this->authorize('update', $group);

        $request->merge(['is_private' => $request->has('is_private')]);
        
        return $group->update($request->all())->refresh();
    }

    /**
     * Delete the speficied group.
     * 
     * @param Group $group
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Group $group)
    {
        $this->authorize('delete', $group);

        return $group->delete();
    }
}