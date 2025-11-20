<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Daniel Ramirez',
                'email' => 'daniel00250@hotmail.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // alcalde
            ],
            [
                'id' => 2,
                'name' => 'felipe',
                'email' => 'felipe@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 6, // contratacion
            ],
            [
                'id' => 3,
                'name' => 'juan',
                'email' => 'juan@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // contratista
            ],
            [
                'id' => 4,
                'name' => 'sanda',
                'email' => 'sanda@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // supervisor
            ],
            [
                'id' => 5,
                'name' => 'david',
                'email' => 'david@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 4, // ordenador gasto
            ],
            [
                'id' => 6,
                'name' => 'yami',
                'email' => 'yami@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 5, // tesoreria
            ],
        ]);
    }
}
