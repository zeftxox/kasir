<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $fillable = ['id_penjualan', 'id_product', 'harga_jual', 'qty', 'subtotal'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
