<?php

namespace Firefly\Test\Fixtures;

use Firefly\Models\Discussion as Model;

class Discussion extends Model
{
    /** @var array */
    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'locked_at',
        'pinned_at',
    ];
}
