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

Publish package files:

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
    ...
],
```
This will allow watchers to be notified when new posts are made in the discussion

### WYSIWYG Editor
You can enable a WYSIWYG editor by adding / updating the flag in the config:
```php
'features' => [
       ...
        'wysiwyg' => [
            'enabled' => true,
            'theme' => 'snow', // More about themes at https://quilljs.com/docs/themes/
            'toolbar_options' => [ // Docs at https://quilljs.com/docs/modules/toolbar/
                ['bold', 'italic', 'underline', 'strike'],
                [['list' => 'ordered'], ['list'=> 'bullet']],
                ['clean'],
            ],
        ],
        ...
    ],
```
This uses the Quill WYSIWYG editor library, docs can be found at: https://quilljs.com/docs.
The snow theme and basic editing controls are provided out of the box in the config, but these can be modified to fit your needs.

## Contributing

You're more than welcome to submit a pull request, or if you're not feeling up to it - create an issue so someone else can pick it up.
