<?php

namespace Firefly\Policies;

use Firefly\Features;
use Firefly\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  $user
     * @param  \Firefly\Models\Post  $post
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
     * @param  \Firefly\Models\Post  $post
     * @return mixed
     */
    public function update($user, Post $post)
    {
        return $user->id == $post->user_id;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  $user
     * @param  \Firefly\Models\Post  $post
     * @return mixed
     */
    public function delete($user, Post $post)
    {
        return $user->id == $post->user_id;
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  $user
     * @param  \Firefly\Models\Post  $post
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
     * @param  \Firefly\Models\Post  $post
     * @return mixed
     */
    public function forceDelete($user, Post $post)
    {
        return true;
    }

    /**
     * Determine whether the user can mark the post correct.
     *
     * @param  $user
     * @param  \Firefly\Models\Post  $post
     * @return mixed
     */
    public function mark($user, Post $post)
    {
        return true;
    }

    /**
     * Determine whether the user can unmark the post correct.
     *
     * @param  $user
     * @param  \Firefly\Models\Post  $post
     * @return mixed
     */
    public function unmark($user, Post $post)
    {
        return true;
    }

    /**
     * Determine whether the user can react to the post.
     *
     * @param  $user
     * @param  \Firefly\Models\Post  $post
     * @return mixed
     */
    public function react($user, Post $post)
    {
        return Features::enabled('reactions');
    }
}
