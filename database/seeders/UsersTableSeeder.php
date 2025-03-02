<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'nama' => 'Admin User',
                'user_level' => 'admin',
                'username' => 'admin123',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Admin No.1',
                'no_handphone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Officer User',
                'user_level' => 'officer',
                'username' => 'officer123',
                'password' => Hash::make('password123'),
                'alamat' => 'Jl. Officer No.2',
                'no_handphone' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
