[![Latest Stable Version](https://img.shields.io/packagist/v/AndreasElia/laravel-firefly.svg)](https://packagist.org/packages/AndreasElia/laravel-firefly)
[![PHP version](https://img.shields.io/packagist/php-v/AndreasElia/laravel-firefly.svg)](https://packagist.org/packages/AndreasElia/laravel-firefly)
[![License](https://img.shields.io/packagist/l/AndreasElia/laravel-firefly.svg)](https://packagist.org/packages/AndreasElia/laravel-firefly)
[![StyleCI](https://github.styleci.io/repos/149909240/shield?branch=master)](https://github.styleci.io/repos/149909240?branch=master)

![Laravel Firefly Logo](/logo.png?raw=true "Laravel Firefly Logo")

# Laravel Firefly

Firefly is a simple forum package for Laravel, created for ease of use and expansion.

The package ships with a frontend included, but by publishing the packages assets you have the flexibility to customize the available templates and make them match your current applications templates, should you so desire.

## Installation

Install the package:

```bash
composer require andreaselia/laravel-firefly
```

Publish package files (config, migrations, assets and views):

```bash
php artisan vendor:publish --provider="Firefly\FireflyServiceProvider"
```

Run the migrations:

```bash
php artisan migrate
```

Add the FireflyUser trait to your User model:

```php
<?php

namespace App\Models;

use Firefly\Traits\FireflyUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, FireflyUser;
}
```

## Optional Features

### Watchers

You can enable users to "watch" discussions by adding / updating the flag in the config:

```php
'features' => [
    'watchers' => true,
    // ...
],
```

This will allow watchers to be notified when new posts are made in the discussion

### WYSIWYG Editor

The WYSIWYG Editor uses the Quill library, and the docs can be found [here](https://quilljs.com/docs).

You can enable a WYSIWYG editor by adding/updating the flag in the config like so:

```php
'features' => [
    // ...
    'wysiwyg' => [
        'enabled' => true,
        'theme' => 'snow', // More about themes at https://quilljs.com/docs/themes/
        'toolbar_options' => [ // Docs at https://quilljs.com/docs/modules/toolbar/
            ['bold', 'italic', 'underline', 'strike'],
            [['list' => 'ordered'], ['list'=> 'bullet']],
            ['clean'],
        ],
    ],
    // ...
],
```

The snow theme and basic editing controls are provided out of the box in the config, but these can be modified to fit your needs.

### Correct Posts

You can enable the ability to mark a post as "correct" indicating that it answers the question or is a promoted post.

```php
'features' => [
    'correct_posts' => true,
    // ...
],
```

### Policies

By default, Firefly policies are very permissive. In order to customize the permissions for your own application, please use your `AuthServiceProvider` file to overwrite the policies by following the steps below.

1. Create your policy files via `php artisan make:policy MyGroupPolicy`
2. In the generated class, extend the base Firefly policy:

```php
<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Firefly\Policies\GroupPolicy;

class MyGroupPolicy extends GroupPolicy
{
    // ...
```

3. Implement whatever policy you wish (use the policies in `vendor/andreaselia/laravel-firefly/src/Policies` for reference)
4. Update the policies array in the `app/Providers/AuthServiceProvider.php` file like so:

```php
<?php

use Firefly\Models\Group;

// ...

protected $policies = [
    Group::class => 'App\Policies\MyGroupPolicy',
];
```

Learn more about Laravel policies [here](https://laravel.com/docs/8.x/authorization#registering-policies).

## Contributing

You're more than welcome to submit a pull request, or if you're not feeling up to it - create an issue so someone else can pick it up.
