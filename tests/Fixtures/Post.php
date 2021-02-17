<?php

namespace Firefly\Test\Fixtures;

use Firefly\Models\Post as Model;

class Post extends Model
{
    /** @var array */
    protected $fillable = [
        'content',
        'user_id',
        'discussion_id',
    ];
}
