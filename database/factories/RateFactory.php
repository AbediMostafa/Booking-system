<?php

namespace Database\Factories;

use App\Models\Rate;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'scariness'=>$this->faker->randomElement([1,2,3,4,5]),
            'room_decoration'=>$this->faker->randomElement([1,2,3,4,5]),
            'hobbiness'=>$this->faker->randomElement([1,2,3,4,5]),
            'creativeness'=>$this->faker->randomElement([1,2,3,4,5]),
            'Mysteriness'=>$this->faker->randomElement([1,2,3,4,5]),
            'room_id'=>Room::factory(),
        ];    }
}
