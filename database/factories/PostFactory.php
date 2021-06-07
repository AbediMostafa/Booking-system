<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
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
            'title' => $this->faker->name,
            'description' => $this->faker->text,
            'image'=>$this->faker->name.'.png',
            'brief'=>$this->faker->text,
            'status'=>$this->faker->randomElement(['disable' ,'enable']),
            'starred'=>$this->faker->randomElement([0,1]),
            'user_id'=>User::factory(),

        ];   
     }
}
