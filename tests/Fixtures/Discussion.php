<?php

namespace Firefly\Test\Fixtures;

use Firefly\Discussion as Model;

class Discussion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'user_id', 'locked_at', 'stickied_at', 'hidden_at',
    ];
}
