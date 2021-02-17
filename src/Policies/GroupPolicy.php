<?php

namespace Firefly\Policies;

use Firefly\Models\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the group.
     *
     * @param  $user
     * @param  \Firefly\Models\Group  $group
     * @return mixed
     */
    public function view($user, Group $group)
    {
        return true;
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param  $user
     * @return mixed
     */
    public function create($user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param  $user
     * @param  \Firefly\Models\Group  $group
     * @return mixed
     */
    public function update($user, Group $group)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param  $user
     * @param  \Firefly\Models\Group  $group
     * @return mixed
     */
    public function delete($user, Group $group)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the group.
     *
     * @param  $user
     * @param  \Firefly\Models\Group  $group
     * @return mixed
     */
    public function restore($user, Group $group)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the group.
     *
     * @param  $user
     * @param  \Firefly\Models\Group  $group
     * @return mixed
     */
    public function forceDelete($user, Group $group)
    {
        return true;
    }
}
