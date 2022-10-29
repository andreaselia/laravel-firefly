<?php

namespace Firefly\Http\Controllers\Api;

use Firefly\Http\Controllers\Controller;
use Firefly\Models\Post;
use Firefly\Models\Reaction;
use Firefly\Services\ReactionService;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    /**
     * Instance of the discussion service.
     *
     * @var \Firefly\Services\ReactionService
     */
    public $reactionService;

    /**
     * Create a new instance of the controller.
     *
     * @param  \Firefly\Services\ReactionService  $reactionService
     */
    public function __construct(ReactionService $reactionService)
    {
        $this->middleware('auth');

        $this->reactionService = $reactionService;
    }

    public function store(Request $request, Post $post)
    {
        $post = $this->reactionService->make($request, $post);

        return $post->reactions;
    }

    public function delete(Post $post, Reaction $reaction)
    {
        $post = $this->reactionService->delete($reaction);

        return $post->reactions;
    }
}
