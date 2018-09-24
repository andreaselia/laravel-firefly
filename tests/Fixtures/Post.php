<?php

namespace Firefly\Test\Fixtures;

use Firefly\Post as Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'user_id', 'discussion_id'
    ];
}