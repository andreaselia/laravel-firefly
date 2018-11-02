<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Group;
use Firefly\Http\Controllers\Controller;
use Firefly\Http\Requests\StoreGroupRequest;
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

        $group = Group::create($request->all());

        return response()->json($group);
    }
}
