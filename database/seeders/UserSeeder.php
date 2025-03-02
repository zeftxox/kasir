<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Admin User',
            'user_level' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'alamat' => 'Jl. Admin 123',
            'no_handphone' => '081234567890'
        ]);

        User::create([
            'nama' => 'Officer User',
            'user_level' => 'officer',
            'username' => 'officer',
            'password' => Hash::make('password'),
            'alamat' => 'Jl. Officer 456',
            'no_handphone' => '089876543210'
        ]);
    }
}
