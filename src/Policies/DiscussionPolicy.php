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
        return true;
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
        return true;
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
}