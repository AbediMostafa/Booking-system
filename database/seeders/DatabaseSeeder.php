<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RunFactories::class);
        $this->call(NavbarSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(GenreRoomSeeder::class);
        $this->call(SpecificMediasSeeder::class);
        $this->call(UserSeeder::class);
    }
}
