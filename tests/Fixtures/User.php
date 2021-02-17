<?php

namespace Firefly\Test\Fixtures;

use Firefly\Traits\FireflyUser;
use Illuminate\Foundation\Auth\User as Model;

class User extends Model
{
    use FireflyUser;

    /** @var array */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
