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
                'route' => 'http://localhost/Misscape/public/'
            ],
            [
                'title' => 'شهرها',
                'name'=>'cities',
                'route' => 'http://localhost/Misscape/public/cities'
            ],

            [
                'title' => 'مجموعه ها',
                'name'=>'collections',
                'route' => 'http://localhost/Misscape/public/collections'
            ],

            [
                'title' => 'ژانر',
                'name'=>'genres',
                'route' => 'http://localhost/Misscape/public/genres'
            ],

            [
                'title' => 'ویژه ها',
                'name'=>'specials',
                'route' => 'http://localhost/Misscape/public/specials'
            ],
        ]);
    }
}
