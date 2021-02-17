<?php

namespace Firefly\Traits;

use Firefly\Models\Discussion;
use Firefly\Models\Post;
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
}
