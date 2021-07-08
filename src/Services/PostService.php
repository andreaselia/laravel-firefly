<?php

namespace Firefly\Services;

use Firefly\Models\Discussion;
use Firefly\Models\Post;
use Illuminate\Http\Request;

class PostService
{
    /**
     * Make a new Post instance and attach it to the user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Models\Discussion $discussion
     * @return mixed
     */
    public function make(Request $request, Discussion $discussion)
    {
        $user = $request->user();

        $post = $user->posts()->make($request->all());

        $discussion->posts()->save($post);

        return $discussion->refresh();
    }

    /**
     * Update the specified post.
     *
     * @param Request $request
     * @param Post $post
     * @return Post
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        return $post->refresh();
    }

    /**
     * Delete the specified post.
     *
     * @param Post $post
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Post $post)
    {
        return $post->delete();
    }

    /**
     * Mark the specified post as correct
     *
     * @param Post $post
     * @return Post
     */
    public function setCorrect(Post $post)
    {
        $post->update(['is_correct'=>true]);

        return $post;
    }

    /**
     * Mark the specified post as not correct
     *
     * @param Post $post
     * @return Post
     */
    public function unsetCorrect(Post $post)
    {
        $post->update(['is_correct'=>false]);

        return $post;
    }
}
