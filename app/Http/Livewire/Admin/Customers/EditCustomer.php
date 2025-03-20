<?php

namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use App\Models\Customer;

class EditCustomer extends Component
{
    public $customerId;
    public $nama_pelanggan, $alamat_pelanggan, $nomor_hp;

    protected $rules = [
        'nama_pelanggan' => 'required|string|max:255',
        'alamat_pelanggan' => 'required|string|max:255',
        'nomor_hp' => 'required|string|max:15|regex:/^[0-9]+$/|unique:customers,nomor_hp',
    ];

    protected $messages = [
        'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
        'alamat_pelanggan.required' => 'Alamat pelanggan wajib diisi.',
        'nomor_hp.required' => 'Nomor HP wajib diisi.',
        'nomor_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
        'nomor_hp.unique' => 'Nomor HP sudah terdaftar. Gunakan nomor yang berbeda.',
    ];

    public function mount($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customerId = $customer->id;
        $this->nama_pelanggan = $customer->nama_pelanggan;
        $this->alamat_pelanggan = $customer->alamat_pelanggan;
        $this->nomor_hp = $customer->nomor_hp;
    }

    public function updateCustomer()
    {
        $this->validate();

        $customer = Customer::findOrFail($this->customerId);
        $customer->update([
            'nama_pelanggan' => $this->nama_pelanggan,
            'alamat_pelanggan' => $this->alamat_pelanggan,
            'nomor_hp' => $this->nomor_hp,
        ]);

        session()->flash('success', 'Data pelanggan berhasil diperbarui!');
        return redirect()->route('admin.customers.index');
    }

    public function render()
    {
        return view('livewire.admin.customers.edit-customer');
    }
}
