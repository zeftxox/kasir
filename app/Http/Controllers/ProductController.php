<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('category'); // Ambil hanya produk aktif
    
        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('id_kategori', $request->category);
        }
    
        // Filter berdasarkan harga minimum
        if ($request->filled('min_price')) {
            $query->where('harga_jual', '>=', $request->min_price);
        }
    
        // Filter berdasarkan harga maksimum
        if ($request->filled('max_price')) {
            $query->where('harga_jual', '<=', $request->max_price);
        }
    
        // Filter berdasarkan stok minimal
        if ($request->filled('min_stock')) {
            $query->where('stok', '>=', $request->min_stock);
        }
    
        // Filter berdasarkan barcode
        if ($request->filled('barcode')) {
            $query->where('barcode', 'LIKE', "%{$request->barcode}%");
        }
    
        // Ambil data kategori untuk dropdown filter
        $categories = Category::all();
        $products = $query->get();
    
        return view('admin.manage-products.index', compact('products', 'categories'));
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
            'nama_produk' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'barcode' => 'required|string|size:13|unique:products,barcode',
            'id_kategori' => 'required|exists:categories,id', // Pastikan kategori valid
        ]);

        Product::create([
            'nama_produk' => $request->nama_produk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'barcode' => $request->barcode,
            'id_kategori' => $request->id_kategori, // Simpan ID kategori, bukan nama
        ]);

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

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'barcode' => 'required|string|size:13|unique:products,barcode,' . $product->id,
            'id_kategori' => 'required|exists:categories,id',
        ]);

        $product->update([
            'nama_produk' => $request->nama_produk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'barcode' => $request->barcode,
            'id_kategori' => $request->id_kategori,
        ]);

        return redirect()->route('admin.manage-products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'isDeleted' => true,
        ]);
        return redirect()->route('admin.manage-products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function history()
    {
        $deletedProducts = Product::where('isDeleted', true)->with('category')->get();
        return view('admin.manage-products.history', compact('deletedProducts'));
    }

    public function restore($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['isDeleted' => false]); // Kembalikan produk

        return redirect()->route('admin.manage-products.history')->with('success', 'Produk berhasil dikembalikan.');
    }


}
