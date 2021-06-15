<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'image'=> "images/cities/{$this->faker->randomElement([
                'esfahan',
                'ilam',
                'karaj',
                'mashhad',
                'shiraz',
                'yazd',
            ])}.jpg"
        ];
    }
}
