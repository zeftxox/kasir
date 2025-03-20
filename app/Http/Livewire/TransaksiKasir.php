<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiKasir extends Component
{
    public $nama_customer, $alamat_customer, $nomor_customer;
    public $username;
    public $barcode = '';
    public $cart = [];
    public $discount = 0;
    public $total_harga = 0;
    public $total_bayar = 0;
    public $kembalian = 0;
    public $uang_bayar = 0;
    public $showNotaPopup = false;
    public $showSuccessPopup = false;
    public $lastTransactionId = null;
    public $lastTransaction = null;
    public $uangBayarValue = 0;
    public $useCustomer = false; // Switch button status
    public $showCustomerForm = false; // Form tambah pelanggan
    public $searchCustomer = '';
    public $filteredCustomers = []; 

    protected $listeners = ['barcodeScanned' => 'processBarcode'];
    public $error_message = '';

    
    public function processBarcode($barcode)
    {
        $this->barcode = $barcode;
        $this->updatedBarcode();
    }
    

    public function updatedBarcode()
    {
        if (!empty($this->barcode)) {
            // Cari produk berdasarkan barcode
            $product = Product::where('barcode', $this->barcode)
                ->where('isDeleted', false)
                ->first();
    
            if (!$product) {
                session()->flash('error', 'Produk tidak ditemukan!');
                // $this->dispatch('productAdded'); 

            } elseif ($product->stok <= 0) {
                session()->flash('error', "Stok produk '{$product->nama_produk}' habis!");
                $this->dispatch('productAdded'); 

            } else {
                $this->addToCart($product->id);
                $this->dispatch('productAdded'); 
            }
    
            // Reset barcode setelah pengecekan
            $this->barcode = '';
        }
    }
    
    

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product || $product->stok < 1) return;
    
        foreach ($this->cart as $index => $item) {
            if ($item['id'] == $productId) {
                $this->cart[$index]['qty'] += 1;
                $this->cart[$index]['subtotal'] = $this->cart[$index]['qty'] * $this->cart[$index]['harga_jual'];
                $this->cart[$index]['harga_discount'] = $this->cart[$index]['subtotal'] - ($this->cart[$index]['subtotal'] * ($this->cart[$index]['discount'] / 100));
                $this->calculateTotal();
                return;
            }
        }
    
        $this->cart[] = [
            'id' => $product->id,
            'nama_produk' => $product->nama_produk,
            'harga_jual' => $product->harga_jual,
            'qty' => 1,
            'discount' => 0, // Default diskon 0%
            'subtotal' => $product->harga_jual,
            'harga_discount' => $product->harga_jual, // Default harga tanpa diskon
        ];
    
        $this->calculateTotal();
    }
    
    public function updateProductDiscount($index, $discount)
    {
        // Validasi input, jika kosong, bukan angka, atau negatif, set ke 0
        if (!is_numeric($discount) || $discount < 0) {
            $discount = 0;
        }

        // Jika diskon lebih dari 100, set ke 100
        if ($discount > 100) {
            $discount = 100;
        }

        // Update nilai di cart
        $this->cart[$index]['discount'] = $discount;

        // Hitung ulang harga setelah diskon
        $this->cart[$index]['harga_discount'] = $this->cart[$index]['subtotal'] - 
            ($this->cart[$index]['subtotal'] * ($discount / 100));

        // Hitung ulang total keseluruhan
        $this->calculateTotal();
        // $this->dispatch('updateDiscountInput', ['index' => $index, 'value' => $discount]);

    }
    public function updatedCart($value, $key)
    {
        // Pastikan perubahan hanya terjadi pada field discount
        if (str_contains($key, 'discount')) {
            [$index,] = explode('.', str_replace('cart.', '', $key)); // Ambil index dari key yang berubah
            $index = (int) $index;
    
            // Jika diskon kosong atau bukan angka, set menjadi 0
            if (empty($this->cart[$index]['discount']) || !is_numeric($this->cart[$index]['discount'])) {
                $this->cart[$index]['discount'] = 0;
            }
    
            // Hitung ulang harga setelah diskon
            $this->cart[$index]['harga_discount'] = $this->cart[$index]['subtotal'] - 
                ($this->cart[$index]['subtotal'] * ($this->cart[$index]['discount'] / 100));
    
            // Hitung ulang total keseluruhan
            $this->calculateTotal();
        }
    }

    public function updateQty($index, $qty)
    {
        if ($qty <= 0) {
            unset($this->cart[$index]);
        } else {
            $this->cart[$index]['qty'] = $qty;
            $this->cart[$index]['subtotal'] = $this->cart[$index]['qty'] * $this->cart[$index]['harga_jual'];
        }
        $this->calculateTotal();
    }

    public function increaseQty($index)
    {
        $this->cart[$index]['qty'] += 1;
        $this->cart[$index]['subtotal'] = $this->cart[$index]['qty'] * $this->cart[$index]['harga_jual'];
        $this->calculateTotal();
    }

    public function decreaseQty($index)
    {
        if ($this->cart[$index]['qty'] > 1) {
            $this->cart[$index]['qty'] -= 1;
            $this->cart[$index]['subtotal'] = $this->cart[$index]['qty'] * $this->cart[$index]['harga_jual'];
        } else {
            unset($this->cart[$index]);
        }
        $this->calculateTotal();
    }


    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->calculateTotal();
    }

    public function updatedDiscount($value)
    {
        $this->discount = is_numeric($value) && $value >= 0 ? min(100, (int) $value) : 0;
        $this->calculateTotal();
    }

    public function updatedUangBayar($value)
    {
        $this->uang_bayar = is_numeric($value) && $value >= 0 ? (int) $value : 0;
        $this->calculateTotal();
    }
    

    public function calculateTotal()
    {
    // 1. Hitung total harga setelah diskon per produk
    $this->total_harga = collect($this->cart)->sum('harga_discount'); 

    // 2. Jika pelanggan memenuhi syarat, terapkan diskon member
    $memberDiscount = 0;
    if ($this->useCustomer && !empty($this->nama_customer) && $this->nomor_customer !== '0000000000000' && $this->total_harga >= 1000000) {
        $memberDiscount = 5;
    }

    // Hitung harga setelah diskon member
    $totalSetelahDiskonMember = $this->total_harga - ($this->total_harga * ($memberDiscount / 100));

    // 3. Diskon eksternal bisa diterapkan oleh siapa saja
    $externalDiscount = is_numeric($this->discount) ? $this->discount : 0;
    $totalSetelahDiskonEksternal = $totalSetelahDiskonMember - ($totalSetelahDiskonMember * ($externalDiscount / 100));

    // Simpan nilai total setelah semua diskon
    $this->total_bayar = max(0, $totalSetelahDiskonEksternal);

    // Flash pesan jika diskon diberikan
    if ($memberDiscount > 0) {
        session()->flash('success', 'Diskon 5% untuk member telah diterapkan');
    }

    // 4. Hitung kembalian
    $this->kembalian = max(0, $this->uang_bayar - $this->total_bayar);
    $this->dispatch('updateKembalian', $this->kembalian);

    }

    public function updatedUseCustomer($value)
    {
        if (!$value) {
            // Jika "Gunakan Pelanggan" di-unselect, reset data pelanggan dan diskon
            $this->nama_customer = null;
            $this->alamat_customer = null;
            $this->nomor_customer = null;
            $this->discount = 0; // Reset diskon
        }

        // Hitung ulang total
        $this->calculateTotal();
    }

    public function updatedSearchCustomer()
    {
        if (empty($this->searchCustomer)) {
            $this->filteredCustomers = [];
            return;
        }
        $this->filteredCustomers = Customer::where('isDeleted', false)
            ->where(function($query) {
                $query->where('nama_pelanggan', 'like', "%{$this->searchCustomer}%")
                    ->orWhere('nomor_hp', 'like', "%{$this->searchCustomer}%");
            })
            ->take(5)
            ->get();
    }

    public function selectCustomer($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $this->nama_customer = $customer->nama_pelanggan;
            $this->alamat_customer = $customer->alamat_pelanggan;
            $this->nomor_customer = $customer->nomor_hp;
            $this->filteredCustomers = [];
            $this->calculateTotal();
        }
        session()->flash('success', 'Pelanggan dipilih!');
    }

    public function toggleCustomerForm()
    {
        $this->showCustomerForm = !$this->showCustomerForm;
    }

    public function saveCustomer()
    {
        $this->validate([
            'nama_customer' => 'required|string|max:255',
            'alamat_customer' => 'nullable|string|max:255',
            'nomor_customer' => 'required|string|max:15|unique:customers,nomor_hp',
        ]);

        Customer::create([
            'nama_pelanggan' => $this->nama_customer,
            'alamat_pelanggan' => $this->alamat_customer,
            'nomor_hp' => $this->nomor_customer,
        ]);

        session()->flash('success', 'Pelanggan berhasil ditambahkan!');
        $this->showCustomerForm = false;
    }

    public function saveTransaction()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Tambahkan minimal satu produk!');
            return;

        }
        if ($this->uang_bayar < $this->total_bayar) {
            session()->flash('error', 'Masukkan Nominal Bayar yang cukup!');
            return;
        }

        // Validasi stok sebelum transaksi
        foreach ($this->cart as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->stok == 0) {
                session()->flash('error', "Stok produk '{$item['nama_produk']}' habis");
                return;
            }elseif ($product->stok < $item['qty']) {
                session()->flash('error', "Stok produk {$item['nama_produk']} hanya tersisa {$product->stok}");
                return;
            }
        }

        DB::transaction(function () {
            $customerName = $this->useCustomer && !empty($this->nama_customer) ? $this->nama_customer : null;
            $customerPhone = $this->useCustomer && !empty($this->nomor_customer) ? $this->nomor_customer : '0000000000000';
        
            // Pastikan tidak ada duplikasi nomor HP
            $customer = Customer::firstOrCreate(
                ['nomor_hp' => $customerPhone], // Cek berdasarkan nomor HP
                ['nama_pelanggan' => $customerName, 'alamat_pelanggan' => $this->alamat_customer ?? null]
            );

            $penjualan = Penjualan::create([
                'id_user' => Auth::id(),
                'id_customer' => $customer ? $customer->id : null,
                'discount' => $this->discount,
                'total_harga' => $this->total_harga,
                'total_bayar' => $this->total_bayar,
                'nominal_bayar' => $this->uang_bayar,
                'kembalian' => max($this->kembalian, 0), // Pastikan kembalian tidak negatif
                // 'tanggal_penjualan' => now(),
            ]);

            foreach ($this->cart as $item) {
                $product = Product::find($item['id']);
    
                // Cek lagi stok sebelum decrement
                if ($product && $product->stok >= $item['qty']) {
                    DetailPenjualan::create([
                        'id_penjualan' => $penjualan->id,
                        'id_products' => $item['id'],
                        'harga_jual' => $item['harga_jual'],
                        'qty' => $item['qty'],
                        'subtotal' => $item['subtotal'],
                        'discount' => $item['discount'], // Simpan diskon produk
                        'harga_discount' => $item['harga_discount'], // Simpan harga setelah diskon            
                    ]);
    
                    // Kurangi stok produk di database
                    $product->decrement('stok', $item['qty']);
                }
            }
            $this->lastTransaction = $penjualan->load('detailPenjualan.product', 'customer', 'user');
        });

        $this->showSuccessPopup = true;
        session()->flash('success', 'Transaksi berhasil disimpan!');
    }

    public function showNota()
    {
        $this->showSuccessPopup = false;
        $this->showNotaPopup = true;
    }
    public function resetFields()
    {
        $this->discount = 0;
        $this->uang_bayar = 0;
    }
    
    
    public function resetTransaction()
    {
        $this->reset([
            'cart',
            'discount',  // Reset diskon
            'total_harga',
            'total_bayar',
            'kembalian',
            'uang_bayar', // Reset uang bayar
            'barcode',
            'showSuccessPopup',
            'showNotaPopup',
            'lastTransaction'
        ]);
        
        session()->flash('success', 'Transaksi berhasil disimpan!');
        $this->dispatch('resetTransaction');

        
    }
    
    
    public function render()
    {
        return view('livewire.transaksi-kasir');
    }
}
