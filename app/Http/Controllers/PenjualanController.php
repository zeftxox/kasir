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

    public function searchProduct(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('stok', '>', 0)
                    ->where(function ($q) use ($query) {
                        $q->where('nama_produk', 'like', "%$query%")
                          ->orWhere('barcode', 'like', "%$query%");
                    })
                    ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            // Validasi agar `total_harga` tidak NULL
            if (!$request->total_harga || $request->total_harga <= 0) {
                throw new \Exception("Total harga tidak boleh kosong atau nol.");
            }
    
            // Cek apakah pelanggan sudah ada atau buat baru
            $customer = null;
            if ($request->nama_customer) {
                $customer = Customer::firstOrCreate(
                    ['nama_pelanggan' => $request->nama_customer],
                    [
                        'alamat_pelanggan' => $request->alamat_customer ?? '', 
                        'nomor_hp' => $request->nomor_customer ?? null
                    ]
                );
            }
    
            // Simpan transaksi
            $penjualan = Penjualan::create([
                'id_user'          => Auth::id(),
                'id_customer'      => $customer ? $customer->id : null,
                'discount'         => $request->discount ?? 0,
                'total_harga'      => $request->total_harga, // **Pastikan tidak NULL**
                'penyesuaian'      => $request->penyesuaian ?? 0,
                'total_bayar'      => $request->total_bayar,
                'kembalian'        => $request->kembalian,
                'tanggal_penjualan'=> now()
            ]);
    
            foreach ($request->products as $produk) {
                $product = Product::findOrFail($produk['id_product']);
    
                if ($product->stok < $produk['qty']) {
                    throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi.");
                }
    
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_product'   => $produk['id_product'],
                    'harga_jual'   => $produk['harga_jual'],
                    'qty'          => $produk['qty'],
                    'subtotal'     => $produk['subtotal'],
                    'tanggal_penjualan' => now()
                ]);
    
                $product->decrement('stok', $produk['qty']);
            }
        });
    
        return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan.']);
    }
            

    public function show($id)
    {
        $penjualan = Penjualan::with('detailPenjualan.product', 'customer')->findOrFail($id);
        return view('admin.penjualan.show', compact('penjualan'));
    }
}
