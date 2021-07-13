<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecificMediasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specific_medias')->insert([
            ['name' => 'first_page_video'],
            ['name' => 'first_page_full_image'],
            ['name' => 'first_page_full_video'],
        ]);
    }
}
