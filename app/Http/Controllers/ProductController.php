<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
public function index(Request $request)
{
    $perPage = $request->input('per_page', 5); // Default 5 per halaman
    $query = Product::where('isDeleted', false)->with('category');

    // Penerapan filter
    if ($request->filled('nama_produk')) {
        $query->where('nama_produk', 'like', '%' . $request->nama_produk . '%');
    }
    if ($request->filled('kategori')) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('kategori', 'like', '%' . $request->kategori . '%');
        });
    }
    if ($request->filled('min_price')) {
        $query->where('harga_jual', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('harga_jual', '<=', $request->max_price);
    }
    if ($request->filled('stok')) {
        if ($request->stok_op == 'lebih_besar') {
            $query->where('stok', '>=', $request->stok);
        } else {
            $query->where('stok', '<=', $request->stok);
        }
    }
    if ($request->filled('barcode')) {
        $query->where('barcode', 'like', '%' . $request->barcode . '%');
    }

    // Terapkan paginasi setelah filter
    $products = $query->paginate($perPage)->appends($request->query());

    return view('admin.manage-products.index', compact('products', 'perPage'));
}
    
    public function create()
    {
        // Ambil semua kategori agar bisa ditampilkan dalam dropdown
        $categories = Category::all();
        return view('admin.manage-products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk'  => 'required|string|max:255',
            'harga_beli'   => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'barcode'      => 'required|string|size:13|unique:products,barcode',
            'id_kategori'  => 'required|exists:categories,id', // Validasi kategori harus ada
        ]);

        Product::create($validated); // Simpan data langsung dari hasil validasi

        return redirect()->route('admin.manage-products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.manage-products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'nama_produk'  => 'required|string|max:255',
            'harga_beli'   => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'barcode'      => 'required|string|size:13|unique:products,barcode,' . $product->id,
            'id_kategori'  => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        return redirect()->route('admin.manage-products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['isDeleted' => true]); // Tandai sebagai terhapus

        return redirect()->route('admin.manage-products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function history(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Default 10 jika tidak dipilih
    
        $deletedProducts = Product::where('isDeleted', true)
            ->with('category')
            ->paginate($perPage);
    
        return view('admin.manage-products.history', compact('deletedProducts', 'perPage'));
    }
    

    public function restore($id)
    {
        $product = Product::where('isDeleted', true)->findOrFail($id);
        $product->update(['isDeleted' => false]); // Kembalikan produk

        return redirect()->route('admin.manage-products.history')->with('success', 'Produk berhasil dikembalikan.');
    }
}
