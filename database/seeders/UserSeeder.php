<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            'name' => 'admin',
            'email' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('admin!@#$'), // password
            'remember_token' => '',
            ],
            [
                'name' => 'user',
                'email' => 'user',
                'email_verified_at' => now(),
                'password' => Hash::make('user!@#$'), // password
                'remember_token' => '',
            ]
    ]);
    }
}
