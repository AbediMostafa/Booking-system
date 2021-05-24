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
            'میزان ترسناکی'=>$this->faker->randomElement([1,2,3,4,5]),
            'طراحی اتاق'=>$this->faker->randomElement([1,2,3,4,5]),
            'سرگرمی و جذابیت'=>$this->faker->randomElement([1,2,3,4,5]),
            'خلاقیت در بازی'=>$this->faker->randomElement([1,2,3,4,5]),
            'درجه کیفیت معما'=>$this->faker->randomElement([1,2,3,4,5]),
            'room_id'=>Room::factory(),
        ];    }
}
