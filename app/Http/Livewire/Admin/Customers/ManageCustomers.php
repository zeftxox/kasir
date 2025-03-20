<?php

namespace App\Http\Livewire\Admin\Customers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class ManageCustomers extends Component
{
    use WithPagination;

    public $search = '';
    public $searchPhone = '';
    public $perPage = 10;
    public $showDeleted = false;

    // Variabel untuk modal
    public $isOpenCreate = false;
    public $isOpenEdit = false;
    public $customerId;
    public $nama_pelanggan, $alamat_pelanggan, $nomor_hp;

    protected $queryString = [
        'showDeleted' => ['except' => false], // Menyimpan nilai dalam URL jika true
        'search' => ['except' => ''], // Menyimpan pencarian juga
        'searchPhone' => ['except' => ''],
    ];  

    protected $listeners = [
        'confirmDeleteCustomer' => 'softDeleteCustomer',
        'confirmRestoreCustomer' => 'restoreCustomer',
    ];

    protected $messages = [
        'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
        'alamat_pelanggan.required' => 'Alamat pelanggan wajib diisi.',
        'nomor_hp.required' => 'Nomor HP wajib diisi.',
        'nomor_hp.unique' => 'Nomor HP sudah terdaftar. Gunakan nomor yang berbeda.',
        'nomor_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
    ];

    // Fungsi untuk membuka modal Create dan mereset error message
    public function openCreateModal()
    {
        $this->reset(['nama_pelanggan', 'alamat_pelanggan', 'nomor_hp']);
        $this->resetValidation(); // Reset error message
        $this->isOpenCreate = true;
        $this->isOpenEdit = false; // Pastikan modal Edit ditutup
    }
    
    public function toggleHistory()
    {
        $this->showDeleted = !$this->showDeleted;
        $this->resetPage();
    }

    // Fungsi untuk membuka modal Edit dan mereset error message
    public function openEditModal($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customerId = $customer->id;
        $this->nama_pelanggan = $customer->nama_pelanggan;
        $this->alamat_pelanggan = $customer->alamat_pelanggan;
        $this->nomor_hp = $customer->nomor_hp;

        $this->resetValidation(); // Reset error message
        $this->isOpenEdit = true;
        $this->isOpenCreate = false; // Pastikan modal Create ditutup
    }

    // Fungsi untuk menyimpan data pelanggan baru
    public function createCustomer()
    {
        $this->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat_pelanggan' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:15|regex:/^[0-9]+$/|unique:customers,nomor_hp',
        ]);

        Customer::create([
            'nama_pelanggan' => $this->nama_pelanggan,
            'alamat_pelanggan' => $this->alamat_pelanggan,
            'nomor_hp' => $this->nomor_hp,
        ]);

        session()->flash('success', 'Pelanggan berhasil ditambahkan!');
        $this->isOpenCreate = false;
    }

    // Fungsi untuk mengupdate data pelanggan
    public function updateCustomer()
    {
        $this->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat_pelanggan' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:15|regex:/^[0-9]+$/|unique:customers,nomor_hp,' . $this->customerId,
        ]);

        $customer = Customer::findOrFail($this->customerId);
        $customer->update([
            'nama_pelanggan' => $this->nama_pelanggan,
            'alamat_pelanggan' => $this->alamat_pelanggan,
            'nomor_hp' => $this->nomor_hp,
        ]);

        session()->flash('success', 'Data pelanggan berhasil diperbarui!');
        $this->isOpenEdit = false;
    }
    public function deleteConfirm($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    public function restoreConfirm($id)
    {
        $this->dispatch('confirm-restore', id: $id);
    }

    public function softDeleteCustomer($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->update(['isDeleted' => true]);
            $this->dispatch('refreshTable');
        }
        session()->flash('success', 'Pelanggan berhasil dihapus.');
    }

    public function restoreCustomer($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->update(['isDeleted' => false]);
            $this->dispatch('refreshTable');
        }
        session()->flash('success', 'Pelanggan berhasil direstore.');
    }

    
    public function render()
    {
        $query = Customer::query();

        // Filter berdasarkan status isDeleted
        if ($this->showDeleted) {
            $query->where('isDeleted', true);
        } else {
            $query->where('isDeleted', false);
        }


        if (!empty($this->search)) {
            $query->where('nama_pelanggan', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->searchPhone)) {
            $query->where('nomor_hp', 'like', '%' . $this->searchPhone . '%');
        }

        $customers = $query->paginate($this->perPage);

        return view('livewire.admin.customers.manage-customers', compact('customers'));
    }
}
