<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'display_name' => $this->faker->name,
            'store_name' => $this->faker->name,
            'path' => $this->faker->randomElement([
                'images/carousel/1.jpg',
                'images/carousel/2.jpg',
                'images/carousel/3.jpg',
            ]),
            'place' => $this->faker->randomElement([
                'front', 'banner', 'other', 'video'
            ]),
            'media_of' => $this->faker->randomElement([
                'city', 'collection', 'post', 'room', 'other'
            ]),
            'type' => 'image',
        ];
    }
}
