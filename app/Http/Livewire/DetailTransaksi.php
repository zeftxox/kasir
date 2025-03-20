<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\Auth;

class DetailTransaksi extends Component
{
    public $penjualan;
    public $cart = [];
    public $subtotal = 0;
    public $discount = 0;
    public $penyesuaian = 0;
    public $total_bayar = 0;
    public $kembalian = 0;
    public $user_level;
    public $id; // Tambahkan ini
    public $total_harga = 0;


    protected $rules = [
        'cart.*.qty' => 'required|integer|min:1',
        'discount' => 'nullable|numeric|min:0',
        'penyesuaian' => 'nullable|numeric',
        'total_bayar' => 'required|numeric|min:0',
    ];

    public function mount($id)
    {
        $this->penjualan = Penjualan::with('customer', 'user', 'detailPenjualan.product')->findOrFail($id);
        $this->user_level = Auth::user()->user_level;
    
        // Ambil detail produk dalam transaksi
        $this->cart = $this->penjualan->detailPenjualan->map(function ($item) {
            return [
                'id' => $item->id,
                'nama_produk' => $item->product->nama_produk,
                'harga_jual' => (float) $item->harga_jual,
                'qty' => (int) $item->qty,
                'subtotal' => (float) $item->subtotal,
            ];
        })->toArray();
    
        // Perhitungan awal
        $this->subtotal = (float) array_sum(array_column($this->cart, 'subtotal'));
        $this->discount = (float) ($this->penjualan->discount ?? 0);
        $this->penyesuaian = (float) ($this->penjualan->penyesuaian ?? 0);
    
        // Hitung diskon berdasarkan persen dari subtotal
        $diskonNominal =(float) ($this->subtotal * ($this->discount / 100));
    
        $this->total_harga = $this->subtotal - $diskonNominal + $this->penyesuaian;
        $this->total_bayar = (float) ($this->penjualan->total_bayar ?? 0);
        $this->kembalian = $this->total_bayar - $this->total_harga;
    }
    
    
    public function updatedCart()
    {
        foreach ($this->cart as &$item) {
            // Jika qty kosong atau bukan angka, set ke 1
            if (!is_numeric($item['qty']) || $item['qty'] < 0) {
                $item['qty'] = 0;
            }
    
            // Update subtotal
            $item['subtotal'] = (float) $item['harga_jual'] * (int) $item['qty'];
        }
        $this->calculateTotal();
    }
    

    public function updatedDiscount()
    {
        $this->calculateTotal();
    }

    public function updatedPenyesuaian()
    {
        $this->calculateTotal();
    }

    public function updatedTotalBayar()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->subtotal = (float) array_sum(array_map(function($item) {
            return is_numeric($item['subtotal']) ? (float) $item['subtotal'] : 0;
        }, $this->cart));
    
        // Pastikan discount tidak kosong atau string
        $this->discount = is_numeric($this->discount) ? (float) $this->discount : 0;
        $this->penyesuaian = is_numeric($this->penyesuaian) ? (float) $this->penyesuaian : 0;
    
        // Hitung diskon dalam bentuk rupiah
        $diskonNominal = ($this->subtotal * ($this->discount / 100));
    
        // Perhitungan total
        $this->total_harga = $this->subtotal - $diskonNominal + $this->penyesuaian;
        $this->total_bayar = is_numeric($this->total_bayar) ? (float) $this->total_bayar : 0;
        $this->kembalian = $this->total_bayar - $this->total_harga;
    }
    
    
    

    public function saveTransaction()
    {
        $this->validate([
            'discount' => 'nullable|numeric|min:0|max:100',
            'penyesuaian' => 'nullable|numeric',
            'total_bayar' => 'required|numeric|min:0',
        ]);
    
        foreach ($this->cart as $item) {
            DetailPenjualan::where('id', $item['id'])->update([
                'qty' => (int) $item['qty'],
                'subtotal' => (float) $item['subtotal'],
            ]);
        }
    
        $diskonNominal = ($this->subtotal * ($this->discount / 100));
    
        $this->penjualan->update([
            'discount' => (float) $this->discount, // Simpan sebagai persen
            'penyesuaian' => (float) $this->penyesuaian,
            'total_bayar' => (float) $this->total_bayar,
            'kembalian' => (float) $this->kembalian,
        ]);
    
        session()->flash('success', 'Transaksi berhasil diperbarui.');
        return redirect('/penjualan');
    }
        
    public function render()
    {
        return view('livewire.detail-transaksi');
    }
}
