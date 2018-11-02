<?php

namespace Firefly\Http\Controllers;

use Firefly\Discussion;
use Firefly\Http\Requests\StorePostRequest;
use Firefly\Http\Requests\UpdatePostRequest;
use Firefly\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store the new post.
     *
     * @param \Firefly\Http\Requests\StorePostRequest $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, Discussion $discussion)
    {
        $this->authorize('reply', $discussion);

        $user = $request->user();

        $post = $user->posts()->make(
            $request->only('content')
        );

        $discussion->posts()->save($post);

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Show the form for editing a post.
     *
     * @param \Firefly\Group $group
     * @param \Firefly\Post $post
     * @return \Illuminate\View\View
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('firefly::posts.edit')->withPost($post);
    }

    /**
     * Update the specified post.
     *
     * @param \Firefly\Http\Requests\UpdatePostRequest $request
     * @param \Firefly\Discussion $discussion
     * @param $slug
     * @param \Firefly\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Discussion $discussion, $slug, Post $post)
    {
        $this->authorize('update', $post);

        $post->update(
            $request->only('content')
        );

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Delete the specified post.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Discussion $discussion
     * @param $slug
     * @param \Firefly\Post $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Discussion $discussion, $slug, Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }
}
