<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualans'; // Nama tabel harus sesuai di database

    protected $fillable = [
        'id_user', 'id_customer', 'discount', 'total_harga', 
        'penyesuaian', 'total_bayar', 'kembalian', 'tanggal_penjualan'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailPenjualan() // Perbaikan: Nama function sesuai dengan relasi di Laravel
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }
}
