<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'body' => $this->faker->text,
            'up_rate' => $this->faker->numberBetween($min = 1, $max = 10),
            'down_rate' => $this->faker->numberBetween($min = 1, $max = 10),
            'status'=>$this->faker->randomElement(['disagree','agree']),
            'user_id'=>User::factory(),
        ];
    }
}
