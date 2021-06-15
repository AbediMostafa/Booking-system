<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genre_room')->insert([
            [
                'room_id'=>1,
                'genre_id'=>1
            ],
            [
                'room_id'=>1,
                'genre_id'=>2
            ],
            [
                'room_id'=>2,
                'genre_id'=>1
            ],
            [
                'room_id'=>2,
                'genre_id'=>2
            ],
            [
                'room_id'=>3,
                'genre_id'=>1
            ],
            [
                'room_id'=>4,
                'genre_id'=>1
            ],
            [
                'room_id'=>5,
                'genre_id'=>1
            ],
            [
                'room_id'=>6,
                'genre_id'=>1
            ],
            [
                'room_id'=>6,
                'genre_id'=>2
            ],
            [
                'room_id'=>6,
                'genre_id'=>3
            ],
            [
                'room_id'=>7,
                'genre_id'=>1
            ],
            [
                'room_id'=>8,
                'genre_id'=>1
            ],
            [
                'room_id'=>9,
                'genre_id'=>1
            ],
            [
                'room_id'=>10,
                'genre_id'=>1
            ],
            [
                'room_id'=>10,
                'genre_id'=>2
            ],
            [
                'room_id'=>10,
                'genre_id'=>3
            ],
            [
                'room_id'=>9,
                'genre_id'=>2
            ],
            [
                'room_id'=>9,
                'genre_id'=>3
            ],
            [
                'room_id'=>8,
                'genre_id'=>2
            ],
            [
                'room_id'=>8,
                'genre_id'=>3
            ],
        ]);
    }
}
