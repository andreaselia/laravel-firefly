<?php

namespace Firefly\Factories;

use App\Models\User;
use Firefly\Models\Post;
use Firefly\Models\Discussion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'discussion_id' => Discussion::factory(),
            'user_id' => User::factory(),
            'content' => $title = $this->faker->sentences,
        ];
    }
}
