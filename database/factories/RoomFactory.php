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
            'name' => $this->faker->randomElement([
                'کابوس',
                'شبه بازارچه',
                'قاتل فراری',
                'روح سرگردان',
                'طاعون',
                'شام آخر',
                'هکر',
                'زندان خون آشام',
            ]),
            'description' => $this->faker->text,
            'image'=>$this->faker->randomElement([
                'images/carousel/1.jpg',
                'images/carousel/2.jpg',
                'images/carousel/3.jpg',
            ]),
            'banner'=>$this->faker->name.'.png',
            'price'=>$this->faker->numberBetween($min = 100, $max = 350),
            'max_person'=>$this->faker->numberBetween($min = 11, $max = 20),
            'min_person'=>$this->faker->numberBetween($min = 4, $max = 8),
            'game_time'=>$this->faker->numberBetween($min = 60, $max = 120),
            'hardness'=>$this->faker->randomElement([1,2,3,4,5]),
            'status'=>$this->faker->randomElement(['disable' ,'enable']),
            'type'=>$this->faker->randomElement(['special', 'new']),
            'is_special'=>$this->faker->randomElement([0,1]),
            'district' => $this->faker->name,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber  ,
            'mobile' => $this->faker->e164PhoneNumber  ,
            'collection_id' => Collection::factory()  ,
            'city_id' => City::factory()  ,


        ];  
    }
    

}
