<?php

namespace Firefly\Traits;

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
