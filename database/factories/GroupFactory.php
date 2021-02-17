<?php

namespace Firefly\Factories;

use Firefly\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->colorName,
            'slug' => Str::lower($this->faker->colorName),
            'color' => $this->faker->hexColor,
            'is_private' => $this->faker->random_int(0, 1),
        ];
    }
}
