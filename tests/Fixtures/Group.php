<?php

namespace Firefly\Test\Fixtures;

use Firefly\Models\Group as Model;

class Group extends Model
{
    /** @var array */
    protected $fillable = [
        'name',
        'slug',
        'color',
        'is_private',
    ];
}
