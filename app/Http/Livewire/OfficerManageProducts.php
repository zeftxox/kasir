<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OfficerManageProducts extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $searchNama = '';
    public $searchKategori = '';
    public $searchBarcode = '';
    public $editStock = [];
    public $oldStock = [];
    public $selectedProductId;
    public $user_level;

    protected $rules = [
        'editStock.*' => 'required|integer|min:0',
    ];

    protected $listeners = [
        'confirmUpdateStock' => 'updateStock',
    ];

    public function mount()
    {
        $this->user_level = Auth::user()->user_level;

        $products = Product::all();
        foreach ($products as $product) {
            $this->oldStock[$product->id] = $product->stok;
            $this->editStock[$product->id] = $product->stok;
        }
    }

    public function updatingSearchNama()
    {
        $this->resetPage();
    }

    public function updatingSearchKategori()
    {
        $this->resetPage();
    }

    public function updatingSearchBarcode()
    {
        $this->resetPage();
    }

    public function confirmUpdateStock($productId)
    {
        $this->selectedProductId = $productId;
        $this->dispatch('showUpdateConfirmation');
    }

    public function updateStock()
    {
        $this->validate();

        if ($this->selectedProductId) {
            $product = Product::find($this->selectedProductId);
            if ($product && isset($this->editStock[$this->selectedProductId])) {
                $product->update(['stok' => $this->editStock[$this->selectedProductId]]);
                $this->oldStock[$this->selectedProductId] = $this->editStock[$this->selectedProductId]; // Simpan stok terbaru
                
                $this->dispatch('showSuccessMessage', ['message' => 'Stok berhasil diperbarui.']);
                $this->reset('selectedProductId'); // Reset setelah update
            }
        }
    }

    public function render()
    {
        $query = Product::query();

        if (!empty($this->searchNama)) {
            $query->where('nama_produk', 'like', '%' . $this->searchNama . '%');
        }

        if (!empty($this->searchKategori)) {
            $query->whereHas('category', function ($q) {
                $q->where('kategori', 'like', '%' . $this->searchKategori . '%');
            });
        }

        if (!empty($this->searchBarcode)) {
            $query->where('barcode', 'like', '%' . $this->searchBarcode . '%');
        }

        $products = $query->paginate($this->perPage);

        return view('livewire.officer-manage-products', compact('products'));
    }
}
