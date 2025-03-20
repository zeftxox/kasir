<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $fillable = ['id_penjualan', 'id_products', 'harga_jual', 'qty', 'subtotal', 'discount', 'harga_discount', 'tanggal_penjualan'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_products');
    }
}
