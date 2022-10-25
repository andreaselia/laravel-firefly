<?php

namespace Firefly\Services;

use Firefly\Models\Post;
use Firefly\Models\Reaction;
use Illuminate\Http\Request;

class ReactionService
{
    /**
     * Add a new reaction, or delete it if it already exists.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Firefly\Models\Post  $post
     * @return \Firefly\Models\Post
     */
    public function make(Request $request, Post $post)
    {
        $user = $request->user();

        if ($request->get('reaction')) {
            $existingReaction = Reaction::where([
                'user_id'  => $user->id,
                'reaction' => $request->get('reaction'),
                'post_id'  => $post->id,
            ])->first();

            if ($existingReaction) {
                return $this->delete($existingReaction);
            }

            $reaction = new Reaction([
                'user_id'  => $user->id,
                'reaction' => $request->get('reaction'),
            ]);

            $post->reactions()->save($reaction);
        }

        return $post->refresh();
    }

    /**
     * Delete the specified reaction.
     *
     * @param  \Firefly\Models\Reaction  $reaction
     * @return \Firefly\Models\Post
     *
     * @throws \Exception
     */
    public function delete(Reaction $reaction)
    {
        $reaction->delete();

        return $reaction->post->fresh();
    }
}
