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
            'scary'=>$this->faker->randomElement([1,2,3,4,5]),
            'design'=>$this->faker->randomElement([1,2,3,4,5]),
            'fun_charm'=>$this->faker->randomElement([1,2,3,4,5]),
            'creativity'=>$this->faker->randomElement([1,2,3,4,5]),
            'puzzle'=>$this->faker->randomElement([1,2,3,4,5]),
            'room_id'=>Room::factory(),
        ];    }
}
