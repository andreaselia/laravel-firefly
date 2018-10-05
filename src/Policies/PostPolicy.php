<?php

namespace Firefly\Policies;

use Firefly\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  $user
     * @param  \Firefly\Post  $post
     * @return mixed
     */
    public function view($user, Post $post)
    {
        return true;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  $user
     * @return mixed
     */
    public function create($user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  $user
     * @param  \Firefly\Post  $post
     * @return mixed
     */
    public function update($user, Post $post)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  $user
     * @param  \Firefly\Post  $post
     * @return mixed
     */
    public function delete($user, Post $post)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  $user
     * @param  \Firefly\Post  $post
     * @return mixed
     */
    public function restore($user, Post $post)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  $user
     * @param  \Firefly\Post  $post
     * @return mixed
     */
    public function forceDelete($user, Post $post)
    {
        return true;
    }
}