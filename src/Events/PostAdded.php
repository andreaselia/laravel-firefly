<?php

namespace Firefly\Events;

use Firefly\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Post that was added.
     *
     * @var Post
     */
    public $post;

    /**
     * Create a new event instance.
     *
     * @param Post $post
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
