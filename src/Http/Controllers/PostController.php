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
     * Show the form for creating a new post.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store the new post.
     *
     * @param \Firefly\Http\Requests\StorePostRequest $request
     * @param \Firefly\Discussion $discussion
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, Discussion $discussion)
    {
        $this->authorize('create', Post::class);

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

        return response()->json($post);
    }

    /**
     * Hide the specified post.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function hide(Request $request, Post $post)
    {
        $this->authorize('hide', $post);

        $post->hide();

        return redirect()->route('firefly.discussion.show', [$post->discussion->id, $post->discussion->slug]);
    }

    /**
     * Unhide the specified post.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Firefly\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function unhide(Request $request, Post $post)
    {
        $this->authorize('unhide', $post);

        $post->unhide();

        return redirect()->route('firefly.discussion.show', [$post->discussion->id, $post->discussion->slug]);
    }
}
