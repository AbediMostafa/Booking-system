<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\Room;
use Carbon\Carbon;
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
            'started_at'=>Carbon::now()->timezone('Asia/Istanbul')->format('Y-m-d H:i:s'),
            'ended_at'=>Carbon::tomorrow()->timezone('Asia/Istanbul')->format('Y-m-d H:i:s'),
            'room_id'=>Room::factory(),
        ];
    }
}
