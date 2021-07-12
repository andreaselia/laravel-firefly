<?php

namespace Firefly\Listeners;

use Firefly\Events\PostAdded;
use Firefly\Mail\PostAddedEmail;
use Firefly\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class NotifyWatchersPostAdded implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PostAdded $event
     *
     * @return void
     */
    public function handle(PostAdded $event)
    {
        $recipients = $this->getWatchers($event->post);

        if (! $recipients) {
            return;
        }

        $recipients->each(fn ($recipient) => Mail::to($recipient)->send(new PostAddedEmail($event->post)));
    }

    private function getWatchers(Post $post): Collection
    {
        return $post->discussion
            ->watchers()
            ->where('user_id', '<>', $post->user_id)
            ->distinct()
            ->get();
    }
}
