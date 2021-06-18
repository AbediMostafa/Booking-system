<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('navbars')->insert([

            [
                'title' => 'خانه',
                'name'=>'home',
                'route' => '/'
            ],
            [
                'title' => 'شهرها',
                'name'=>'cities',
                'route' => '/cities'
            ],

            [
                'title' => 'مجموعه ها',
                'name'=>'collections',
                'route' => '/collections'
            ],

            [
                'title' => 'ژانر',
                'name'=>'genres',
                'route' => '/genres'
            ],

            [
                'title' => 'ویژه ها',
                'name'=>'specials',
                'route' => '/specials'
            ],
        ]);
    }
}
