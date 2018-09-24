<?php

use Faker\Generator as Faker;

$factory->define(Firefly\Post::class, function (Faker $faker) {
    return [
        'discussion_id' => factory(\Firefly\Discussion::class)->create()->id,
        'user_id' => factory(\App\User::class)->create()->id,
        'text' => $faker->paragraphs(3, true),
    ];
});