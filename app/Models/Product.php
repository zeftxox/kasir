<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kategori', 'nama_produk', 'harga_jual', 'harga_beli', 
        'stok', 'barcode', 'isDeleted'

    ];

    protected $casts = [
        'isDeleted' => 'boolean'
    ];


    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }
    
    public function scopeActive($query)
    {
        return $query->where('isDeleted', false);
    }

    public function reduceStock($qty)
    {
        if ($this->stok < $qty) {
            throw new \Exception("Stok produk $this->nama_produk tidak mencukupi.");
        }
        $this->decrement('stok', $qty);
    }

}
