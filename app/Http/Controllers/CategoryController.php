<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Ambil semua kategori dari tabel categories
        return view('admin.manage-category.index', compact('categories')); // Kirim data ke view
    }
    
    public function create()
    {
        return view('admin.manage-category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        Category::create([
            'kategori' => $request->kategori
        ]);

        return redirect()->route('admin.manage-category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.manage-category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'kategori' => 'required|string|max:255',
        ]);

        $category->update([
            'kategori' => $request->kategori
        ]);

        return redirect()->route('admin.manage-category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
    
            return redirect()->route('admin.manage-category.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.manage-category.index')->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh produk.');
        }
    }
    }
