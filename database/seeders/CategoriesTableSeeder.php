<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['kategori' => 'Elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['kategori' => 'Fashion', 'created_at' => now(), 'updated_at' => now()],
            ['kategori' => 'Makanan & Minuman', 'created_at' => now(), 'updated_at' => now()],
            ['kategori' => 'Alat Rumah Tangga', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
