<?php

namespace Firefly\Policies;

use Firefly\Discussion;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function view($user, Discussion $discussion)
    {
        return true;
    }

    /**
     * Determine whether the user can create discussions.
     *
     * @param  $user
     * @return mixed
     */
    public function create($user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function update($user, Discussion $discussion)
    {
        return $user->id == $discussion->user_id;
    }

    /**
     * Determine whether the user can delete the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function delete($user, Discussion $discussion)
    {
        return $user->id == $discussion->user_id;
    }

    /**
     * Determine whether the user can restore the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function restore($user, Discussion $discussion)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function forceDelete($user, Discussion $discussion)
    {
        return true;
    }

    /**
     * Determine whether the user can lock the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function lock($user, Discussion $discussion)
    {
        return is_null($discussion->locked_at);
    }

    /**
     * Determine whether the user can unlock the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function unlock($user, Discussion $discussion)
    {
        return ! is_null($discussion->locked_at);
    }

    /**
     * Determine whether the user can stick the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function stick($user, Discussion $discussion)
    {
        return is_null($discussion->stickied_at);
    }

    /**
     * Determine whether the user can unstick the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function unstick($user, Discussion $discussion)
    {
        return ! is_null($discussion->stickied_at);
    }

    /**
     * Determine whether the user can hide the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function hide($user, Discussion $discussion)
    {
        return true;
    }

    /**
     * Determine whether the user can unhide the discussion.
     *
     * @param  $user
     * @param  \Firefly\Discussion  $discussion
     * @return mixed
     */
    public function unhide($user, Discussion $discussion)
    {
        return true;
    }
}
