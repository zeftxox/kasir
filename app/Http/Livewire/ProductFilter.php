<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class ProductFilter extends Component
{
    public $category;
    public $min_price;
    public $max_price;
    public $min_stock;
    public $barcode;

    public function render()
    {
        $query = Product::with('category')->where('isDeleted', false);

        if ($this->category) {
            $query->where('id_kategori', $this->category);
        }
        if ($this->min_price) {
            $query->where('harga_jual', '>=', $this->min_price);
        }
        if ($this->max_price) {
            $query->where('harga_jual', '<=', $this->max_price);
        }
        if ($this->min_stock) {
            $query->where('stok', '>=', $this->min_stock);
        }
        if ($this->barcode) {
            $query->where('barcode', 'LIKE', "%{$this->barcode}%");
        }

        return view('livewire.product-filter', [
            'products' => $query->get(),
            'categories' => Category::all()
        ]);
    }
}
