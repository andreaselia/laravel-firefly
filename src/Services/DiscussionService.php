<?php

namespace Firefly\Services;

use Firefly\Models\Discussion;
use Firefly\Models\Group;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class DiscussionService
{
    /**
     * Make a new discussion.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Models\Group    $group
     *
     * @return \Firefly\Models\Discussion
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
     * Update the specified discussion.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \Firefly\Models\Discussion $discussion
     *
     * @return \Firefly\Models\Discussion
     */
    public function update(Request $request, Discussion $discussion)
    {
        $discussion->update($request->all());

        return $discussion->refresh();
    }

    /**
     * Delete the specified discussion.
     *
     * @param \Firefly\Models\Discussion $discussion
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Discussion $discussion)
    {
        return $discussion->delete();
    }

    /**
     * Update a status of the specified discussion.
     *
     * @param Discussion $discussion
     * @param            $type
     */
    public function updateState(Discussion $discussion, $type)
    {
        if (!method_exists($discussion, $type)) {
            throw new \BadMethodCallException("Method {$type} not found.");
        }

        return $discussion->{$type}();
    }

    /**
     * Watch the specified discussion.
     *
     * @param \Firefly\Models\Discussion $discussion
     * @param Illuminate\Foundation\Auth\User $user
     *
     * @return bool|null
     * @throws \Exception
     */
    public function watch(Discussion $discussion, User $user)
    {
        return $discussion->watchers()->syncWithoutDetaching([$user->id]);
    }

    /**
     * Unwatch the specified discussion.
     *
     * @param \Firefly\Models\Discussion $discussion
     * @param Illuminate\Foundation\Auth\User $user
     *
     * @return bool|null
     * @throws \Exception
     */
    public function unwatch(Discussion $discussion, User $user)
    {
        return $discussion->watchers()->detach($user->id);
    }
}
