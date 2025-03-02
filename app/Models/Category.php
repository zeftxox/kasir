<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tidak perlu deklarasi jika tabel sudah benar di database
    protected $fillable = ['kategori'];
}
