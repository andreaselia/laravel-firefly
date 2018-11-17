<?php

namespace Firefly\Services;

use Illuminate\Auth\AuthManager;

class BaseService
{
    /**
     * Instance of the logged in user.
     * 
     * @var \Illuminate\Contracts\Auth\Authenticatable|null 
     */
    protected $user;

    /**
     * Create and new instance of the class.
     * 
     * @param \Illuminate\Auth\AuthManager $manager
     */
    public function __construct(AuthManager $manager)
    {
        $this->user = $manager->guard()->user();
    }
}