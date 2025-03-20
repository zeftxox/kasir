<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class ManageProducts extends Component
{
    use WithPagination;

    // Filter input untuk pencarian
    public $searchNama = '', $searchKategori = '', $searchBarcode = '';
    public $hargaMin = '', $hargaMax = '', $stok = '';
    public $stokOp = 'lebih_besar';
    public $perPage = 5;
    public $showDeleted = false;

    // State untuk modal create/edit
    public $isOpenCreate = false, $isOpenEdit = false;
    public $productId, $nama_produk, $id_kategori, $barcode, $harga_beli, $harga_jual;

    // Custom error messages
    protected $messages = [
        'nama_produk.required' => 'Nama produk wajib diisi.',
        'id_kategori.required' => 'Kategori produk wajib dipilih.',
        'barcode.required' => 'Barcode wajib diisi.',
        'barcode.unique'   => 'Barcode sudah digunakan.',
        'harga_beli.required' => 'Harga beli wajib diisi.',
        'harga_jual.required' => 'Harga jual wajib diisi.',
        'stok.required' => 'Stok wajib diisi.',
        'stok.integer'  => 'Stok harus berupa angka.',
    ];
    
    protected $listeners = [
        'confirmDeleteProduct' => 'softDeleteProduct',
        'confirmRestoreProduct' => 'restoreProduct',
    ];

    // Pastikan variabel yang tidak ingin ditampilkan di query string tidak ikut terkirim
    protected $queryString = [
        'searchNama' => ['except' => ''],
        'searchKategori' => ['except' => ''],
        'searchBarcode' => ['except' => ''],
        'hargaMin' => ['except' => ''],
        'hargaMax' => ['except' => ''],
        'stok' => ['except' => ''],
        'stokOp' => ['except' => 'lebih_besar'],
        'perPage' => ['except' => 5],
        'showDeleted' => ['except' => false],
    ];

    // Fungsi untuk toggle history produk (produk dihapus/aktif)
    public function toggleHistory()
    {
        $this->showDeleted = !$this->showDeleted;
        $this->resetPage();
    }

    public function restoreProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->update(['isDeleted' => false]);
            $this->dispatch('refreshTable');
            session()->flash('success', 'Produk berhasil dikembalikan.');
        }
    }

    public function softDeleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->update(['isDeleted' => true]);
            session()->flash('success', 'Produk berhasil dihapus.');
            $this->dispatch('refreshTable');
        }
    }
    // Reset field dan error ketika membuka modal create
    public function openCreateModal()
    {
        $this->reset(['nama_produk', 'id_kategori', 'barcode',  'harga_beli', 'harga_jual', 'stok']);
        $this->resetValidation();
        $this->isOpenCreate = true;
        $this->isOpenEdit = false;
    }

    // Buka modal edit dan isi field dengan data produk yang dipilih
    public function openEditModal($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->nama_produk = $product->nama_produk;
        $this->id_kategori = $product->id_kategori;
        $this->barcode = $product->barcode;
        $this->harga_beli = $product->harga_beli;
        $this->harga_jual = $product->harga_jual;
        $this->stok = $product->stok;

        $this->resetValidation();
        $this->isOpenEdit = true;
        $this->isOpenCreate = false;
    }
    

    // Membuat produk baru dengan validasi lengkap
    public function createProduct()
    {
        $this->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:categories,id',
            'barcode' => 'required|string|max:13|unique:products,barcode',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        Product::create([
            'nama_produk' => $this->nama_produk,
            'id_kategori' => $this->id_kategori,
            'barcode' => $this->barcode,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
        ]);

        session()->flash('success', 'Produk berhasil ditambahkan!');
        $this->isOpenCreate = false;
    }

    // Mengupdate produk dengan validasi
    public function updateProduct()
    {
        $this->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:categories,id',
            'barcode' => 'required|string|max:50|unique:products,barcode,' . $this->productId,
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $product = Product::findOrFail($this->productId);
        $product->update([
            'nama_produk' => $this->nama_produk,
            'id_kategori' => $this->id_kategori,
            'barcode' => $this->barcode,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
        ]);

        session()->flash('success', 'Produk berhasil diperbarui!');
        $this->isOpenEdit = false;
    }

    public function render()
    {
        $query = Product::query();
        $categories = Category::all();

        // Filter berdasarkan status isDeleted
        if ($this->showDeleted) {
            $query->where('isDeleted', true);
        } else {
            $query->where('isDeleted', false);
        }

        // Filter berdasarkan nama produk
        if ($this->searchNama) {
            $query->where('nama_produk', 'like', '%' . $this->searchNama . '%');
        }

        // Filter berdasarkan kategori berdasarkan nama kategori menggunakan relasi
        if ($this->searchKategori) {
            $query->whereHas('category', function ($q) {
                $q->where('kategori', 'like', '%' . $this->searchKategori . '%');
            });
        }

        // Filter berdasarkan barcode
        if ($this->searchBarcode) {
            $query->where('barcode', 'like', '%' . $this->searchBarcode . '%');
        }

        // Filter berdasarkan harga jual jika diisi
        if ($this->hargaMin !== '') {
            $query->where('harga_jual', '>=', $this->hargaMin);
        }
        if ($this->hargaMax !== '') {
            $query->where('harga_jual', '<=', $this->hargaMax);
        }

        // Filter berdasarkan stok jika diisi dan dengan operator yang dipilih
        if ($this->stok !== '') {
            if ($this->stokOp === 'lebih_besar') {
                $query->where('stok', '>=', $this->stok);
            } else {
                $query->where('stok', '<=', $this->stok);
            }
        }

        $products = $query->paginate($this->perPage);

        return view('livewire.admin.product.manage-products', compact('products', 'categories'));
    }
}
