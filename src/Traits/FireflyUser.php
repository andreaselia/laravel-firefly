<?php

namespace Firefly\Traits;

use Firefly\Models\Discussion;
use Firefly\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait FireflyUser
{
    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function watching(): BelongsToMany
    {
        return $this->belongsToMany(Discussion::class);
    }

    public function isWatching(Discussion $discussion): bool
    {
        return $this
            ->watching()
            ->where('discussion_id', $discussion->id)
            ->exists();
    }
}
