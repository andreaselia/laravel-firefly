<?php

use Faker\Generator as Faker;

$factory->define(Firefly\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'slug' => $faker->unique()->slug,
        'color' => $faker->safeHexColor,
    ];
});