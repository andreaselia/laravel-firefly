<?php

namespace Firefly\Test\Fixtures;

use Firefly\Group as Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'color', 'is_private',
    ];
}
