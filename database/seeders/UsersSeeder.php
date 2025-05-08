<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
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
                'id' => 1,
                'role_id' => 1,
                'name' => 'admin',
                'email' => 'admin',
                'password' => Hash::make('boykhmer'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'role_id' => 1,
                'name' => 'owner',
                'email' => 'owner',
                'password' => Hash::make('boykhmer'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'role_id' => 2,
                'name' => 'netnavin',
                'email' => 'netnavin@gmail.com',
                'password' => Hash::make('boykhmer'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
