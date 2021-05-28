<?php

namespace Firefly\Http\Controllers;

use Firefly\Models\Discussion;
use Firefly\Models\Group;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Show the forum index.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $groups = Group::all();

        $discussionQuery = Discussion::orderBy('created_at', 'desc');
        if (config('firefly.features.watchers') && $request->user()) {
            $discussionQuery->leftJoin('discussion_user', function (JoinClause $join) use ($request) {
                $join->on('discussion_user.discussion_id', '=', 'discussions.id')
                    ->where('discussion_user.user_id', $request->user()->id);
            })->select([
                'discussions.*',
                'discussion_user.user_id as is_being_watched',
            ]);
        }
        $discussions = $discussionQuery->paginate(config('firefly.pagination.discussions'));

        return view('firefly::index')->with(compact('groups', 'discussions'));
    }
}
