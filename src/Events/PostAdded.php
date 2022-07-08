<?php

namespace Firefly\Events;

use Firefly\Models\Post;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostAdded
{
    use Dispatchable, SerializesModels;

    /**
     * Post that was added.
     *
     * @var Post
     */
    public $post;

    /**
     * Create a new event instance.
     *
     * @param  Post  $post
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
