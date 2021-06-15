<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Collection;
use App\Models\Discount;
use App\Models\Genre;
use App\Models\Post;
use App\Models\Rate;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class RunFactories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user= User::factory()->create();
        $city=City::factory()->count(3)->create();
        $post=Post::factory()->count(3)->for($user)->create();
        $room= Room::factory()->count(3)->create();
        $discount=Discount::factory()->count(3)->create();
        $rate=Rate::factory()->count(3)->create();
        $post = Post::factory()->hasComments(3)->create();
        $room = Room::factory()->hasComments(3)->create();
    }
}
