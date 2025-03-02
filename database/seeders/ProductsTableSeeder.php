<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'id_kategori' => 1, // Elektronik
                'nama_produk' => 'Smartphone Samsung',
                'harga_jual' => 5000000,
                'harga_beli' => 4500000,
                'stok' => 10,
                'barcode' => '1234567890123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 2, // Fashion
                'nama_produk' => 'Kaos Polos Hitam',
                'harga_jual' => 75000,
                'harga_beli' => 50000,
                'stok' => 50,
                'barcode' => '1234567890124',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 3, // Makanan & Minuman
                'nama_produk' => 'Kopi Luwak',
                'harga_jual' => 150000,
                'harga_beli' => 120000,
                'stok' => 20,
                'barcode' => '1234567890125',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
