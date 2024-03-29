<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Collection;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'price'=>$this->faker->numberBetween($min = 100, $max = 350),
            'max_person'=>$this->faker->numberBetween($min = 11, $max = 20),
            'min_person'=>$this->faker->numberBetween($min = 4, $max = 8),
            'game_time'=>$this->faker->numberBetween($min = 60, $max = 120),
            'is_special'=>$this->faker->randomElement([0 ,1]),
            'is_new'=>$this->faker->randomElement([0 ,1]),
            'district' => $this->faker->name,
            'address' => $this->faker->address,
            'hardness'=>$this->faker->numberBetween($min = 1, $max = 5),
            'website' => $this->faker->randomElement([
            ]),

            'phone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->e164PhoneNumber  ,
            'collection_id' => Collection::factory()  ,
            'city_id' => City::factory(),
        ];
    }


}
