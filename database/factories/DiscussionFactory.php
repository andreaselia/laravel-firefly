<?php

namespace Firefly\Factories;

use App\Models\User;
use Firefly\Models\Discussion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DiscussionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discussion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $title = $this->faker->sentence,
            'slug' => Str::slug($title),
            'locked_at' => rand(0, 3) > 2 ? now() : null,
            'pinned_at' => rand(0, 3) > 2 ? now() : null,
        ];
    }
}
