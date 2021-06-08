<?php

namespace Database\Factories;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class CollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Collection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->randomElement([
                'اسکیپ پنیک', 
                'برین استورم', 
                'بوم اسکیپ', 
                'نئو', 
                'اسکیپ روت', 
                'نکست اسکیپ روم', 
                'اسکیپ اسکری',
                'انیگما اسکیپ',
                'رد اسکیپ روم',
                'کافه اسکیپ روم',
                'ایگور',
                'آی اسکیپ',
                'وایا روم',
                'هاریبل',
                'لانگ وی',
                ]),
            'image'=>  "images/collections/{$this->faker->randomDigitNot(0)}.jpg",
        ];
    }
}
