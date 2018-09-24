<?php

use Faker\Generator as Faker;

$factory->define(Firefly\Discussion::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'title' => $faker->words(5, true),
        'slug' => $faker->unique()->slug,
    ];
});