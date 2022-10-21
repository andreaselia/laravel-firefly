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
        'corrected_at',
        'is_initial_post',
    ];

    /** @var array */
    protected $dates = [
        'corrected_at',
    ];

    /** @var array */
    protected $casts = [
        'is_initial_post' => 'boolean',
    ];
}
