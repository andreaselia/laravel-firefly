<?php

namespace Firefly\Http\Controllers;

use Firefly\Features;
use Firefly\Http\Requests\StoreDiscussionRequest;
use Firefly\Http\Requests\UpdateDiscussionRequest;
use Firefly\Models\Discussion;
use Firefly\Models\Group;
use Firefly\Services\DiscussionService;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    /**
     * Instance of the discussion service.
     *
     * @var \Firefly\Services\DiscussionService
     */
    public $discussionService;

    /**
     * Create a new instance of the controller.
     *
     * @param  \Firefly\Services\DiscussionService  $service
     */
    public function __construct(DiscussionService $discussionService)
    {
        $this->middleware('auth')->except('show');

        $this->discussionService = $discussionService;
    }

    /**
     * Show the form for creating a new discussion.
     *
     * @param  \Firefly\Models\Group  $group
     * @return \Illuminate\View\View
     */
    public function create(Group $group)
    {
        $this->authorize('create', Discussion::class);

        return view('firefly::discussions.create')->withGroup($group);
    }

    /**
     * Store the new discussion.
     *
     * @param  \Firefly\Http\Requests\StoreDiscussionRequest  $request
     * @param  \Firefly\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDiscussionRequest $request, Group $group)
    {
        $this->authorize('create', Discussion::class);

        $discussion = $this->discussionService->make($request, $group);

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Show the specified discussion.
     *
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\View\View
     */
    public function show(Discussion $discussion, Request $request)
    {
        $posts = $discussion->posts()
            ->withSearch($request->get('search'))
            ->when(Features::enabled('correct_posts'), fn ($query) => $query->orderBy('is_initial_post', 'desc')->orderBy('corrected_at', 'desc'))
            ->paginate(config('firefly.pagination.posts'));

        return view('firefly::discussions.show')->withDiscussion($discussion)
            ->withPosts($posts)
            ->withSearch('search', $request->get('search'));
    }

    /**
     * Show the form for editing a discussion.
     *
     * @param  \Firefly\Models\Group  $group
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\View\View
     */
    public function edit(Group $group, Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        return view('firefly::discussions.edit')->with(compact('group', 'discussion'));
    }

    /**
     * Update the specified discussion.
     *
     * @param  \Firefly\Http\Requests\UpdateDiscussionRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDiscussionRequest $request, Discussion $discussion)
    {
        $this->authorize('update', $discussion);

        $discussion = $this->discussionService->update($request, $discussion);

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Delete the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Discussion $discussion)
    {
        $this->authorize('delete', $discussion);

        $this->discussionService->delete($discussion);

        return redirect()->route('firefly.index');
    }

    /**
     * Lock the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(Request $request, Discussion $discussion)
    {
        $this->authorize('lock', $discussion);

        $this->discussionService->updateState($discussion, 'lock');

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Unlock the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlock(Request $request, Discussion $discussion)
    {
        $this->authorize('unlock', $discussion);

        $this->discussionService->updateState($discussion, 'unlock');

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Pin the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pin(Request $request, Discussion $discussion)
    {
        $this->authorize('pin', $discussion);

        $this->discussionService->updateState($discussion, 'pin');

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }

    /**
     * Unpin the specified discussion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Discussion  $discussion
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unpin(Request $request, Discussion $discussion)
    {
        $this->authorize('unpin', $discussion);

        $this->discussionService->updateState($discussion, 'unpin');

        return redirect()->route('firefly.discussion.show', [$discussion->id, $discussion->slug]);
    }
}
