<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pelanggan', 'alamat_pelanggan', 'nomor_hp','isDeleted'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_customer');
    }
    
}
