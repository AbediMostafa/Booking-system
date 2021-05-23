<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    
    public function definition()
    {
       
        return [
            'title' => $this->faker->name,
            'image'=>$this->faker->name.'.jpg',
            'status'=>$this->faker->randomElement(['disable' ,'enable']),

        ];
    }
}
