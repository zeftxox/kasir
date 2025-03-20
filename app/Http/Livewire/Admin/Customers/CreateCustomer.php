<?php

namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;

class CreateCustomer extends Component
{
    public $nama_pelanggan, $alamat_pelanggan, $nomor_hp;
    
    // Aturan validasi termasuk nomor_hp harus unik
    protected $rules = [
        'nama_pelanggan' => 'required|string|max:255',
        'alamat_pelanggan' => 'required|string|max:255',
        'nomor_hp' => 'required|string|max:15|unique:customers,nomor_hp|regex:/^[0-9]+$/',
    ];

    // Custom error messages
    protected $messages = [
        'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
        'alamat_pelanggan.required' => 'Alamat pelanggan wajib diisi.',
        'nomor_hp.required' => 'Nomor HP wajib diisi.',
        'nomor_hp.unique' => 'Nomor HP sudah terdaftar. Gunakan nomor yang berbeda.',
        'nomor_hp.regex' => 'Nomor HP hanya boleh berisi angka.',

    ];

    public function createCustomer()
    {
        $this->validate(); // Jalankan validasi

        // Simpan data pelanggan ke database
        Customer::create([
            'nama_pelanggan' => $this->nama_pelanggan,
            'alamat_pelanggan' => $this->alamat_pelanggan,
            'nomor_hp' => $this->nomor_hp,
        ]);

        // Set flash message untuk notifikasi sukses
        Session::flash('success', 'Pelanggan berhasil ditambahkan!');
        
        // Redirect ke halaman daftar pelanggan
        return redirect()->route('admin.customers.index');
    }

    public function render()
    {
        return view('livewire.admin.customers.create-customer');
    }
}
