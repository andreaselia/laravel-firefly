<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | Set your eloquent model for your users.
    |
    */

    'user' => App\User::class,

    /*
    |--------------------------------------------------------------------------
    | Group Privatization
    |--------------------------------------------------------------------------
    |
    | Set the group privatization to "true" if you would like to allow the
    | creation of private groups.
    |
    */

    'private_groups' => false,

    /*
    |--------------------------------------------------------------------------
    | Pagination Limits
    |--------------------------------------------------------------------------
    |
    | Set the maximum number of resources that will be shown per page.
    |
    */

    'pagination' => [
        'view'        => 'firefly::pagination.default',
        'groups'      => 12,
        'discussions' => 20,
        'posts'       => 15,
    ],

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
    | Routes
    |--------------------------------------------------------------------------
    |
    | Set any route settings here.
    |
    */

    'discussions' => [
        'prefix' => 'd',
    ],

    'groups' => [
        'prefix' => 'g',
=======
    | Prefixes
    |--------------------------------------------------------------------------
    |
    | Set the route prefixes for each type of resource.
    |
    */

    'prefix' => [
        'group' => 'g',
        'discussion' => 'd',
        'post' => 'p',
>>>>>>> c71acf936fee5a4dcb7e8d00ef2caf2f68641fc9
    ],

    /*
    |--------------------------------------------------------------------------
    | API and Web
    |--------------------------------------------------------------------------
    |
    | Include whichever middleware and namespace(s) you want here.
    |
    */

    'api' => [
        'enabled'    => false,
        'prefix'     => 'api/forum',
        'namespace'  => '\Firefly\Http\Controllers\Api',
        'middleware' => ['api', 'auth:api'],
    ],

    'web' => [
        'name'       => 'firefly.',
        'enabled'    => true,
        'prefix'     => 'forum',
        'namespace'  => '\Firefly\Http\Controllers',
        'middleware' => 'web',
    ],

];
