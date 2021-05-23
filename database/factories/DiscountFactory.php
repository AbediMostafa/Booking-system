<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount'=>$this->faker->numberBetween($min = 10, $max = 35),
            'room_id'=>Room::factory(),
        ];
    }
}
