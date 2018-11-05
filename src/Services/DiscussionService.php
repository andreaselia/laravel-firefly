<?php

namespace Firefly\Services;

use Firefly\Discussion;
use Firefly\Group;
use Illuminate\Http\Request;

class DiscussionService
{
    /**
     * Make a new discussion instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Group $group
     * @return \Firefly\Discussion
     */
    public function make(Request $request, Group $group)
    {
        $user = $request->user();

        // Make the discussion and attach it to the user
        $discussion = $user->discussions()->make(
            $request->only('title')
        );

        $group->discussions()->save($discussion);

        // Make the post and attach it to the user
        $post = $user->posts()->make(
            $request->only('content')
        );

        $discussion->posts()->save($post);

        return $discussion->refresh();
    }

    /**
     * Update the discussion instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @return \Firefly\Discussion
     */
    public function update(Request $request, Discussion $discussion)
    {
        $discussion->update($request->all());
        
        return $discussion->refresh();
    }
}