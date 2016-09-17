<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'user',
                'email' => 'user@waitforit.dev',
                'password' => Hash::make('user')
            ],
            [
                'username' => 'demo',
                'email' => 'demo@waitforit.dev',
                'password' => Hash::make('demo')
            ]
        ]);
    }
}
