<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('customer')->paginate(10);
        return view('admin.penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $customers = Customer::all();
        $produk = Product::where('stok', '>', 0)->get(); // Hanya produk yang tersedia

        return view('admin.penjualan.create', compact('customers', 'produk'));
    }
    
    public function printInvoice($id)
    {
        $penjualan = Penjualan::with('detailPenjualan.product', 'customer')->findOrFail($id);
        
        return view('admin.penjualan.invoice', compact('penjualan'));
    }
    
    
    public function show($id)
    {
        $penjualan = Penjualan::with([
            'customer',
            'user',
            'detailPenjualan.product'
        ])->findOrFail($id);
    
        return view('admin.penjualan.show', compact('penjualan'));
    }

    public function detail($id)
    {
        $penjualan = Penjualan::with([
            'customer',
            'user',
            'detailPenjualan.product'
        ])->findOrFail($id);
    
        return view('admin.penjualan.detail', compact('penjualan'));
    }
    
}
