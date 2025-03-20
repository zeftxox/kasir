<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class ManageUsers extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $nama, $user_level, $username, $password, $alamat, $no_handphone, $user_id;
    public $isModalOpen = false, $showDeleted = false;
    public $searchNama = '', $searchUsername = '', $searchNoHp = '', $filterUserLevel = '';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'user_level' => 'required|in:admin,officer',
        'password' => 'required|min:6',
        'alamat' => 'required|string',
        'no_handphone' => 'required|string|max:15',
    ];

    protected $queryString = [
        'showDeleted' => ['except' => false], // Menyimpan nilai dalam URL jika true
        // 'searchNama' => ['except' => ''], // Menyimpan pencarian juga
        // 'searchUsername' => ['except' => ''],
        // 'searchNoHp' => ['except' => ''],
        // 'filterUserLevel' => ['except' => ''],
    ];  
    protected $listeners = [
        'confirmDeleteUsers' => 'delete',
        'confirmRestoreUsers' => 'restore',
    ];
    
    protected $messages = [
        'nama.required' => 'Nama wajib diisi.',
        'user_level.required' => 'Level wajib diisi.',
        'user_level.in' => 'Level harus admin atau officer.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah terdaftar. Gunakan username yang berbeda.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'alamat.required' => 'Alamat wajib diisi.',
        'no_handphone.required' => 'Nomor HP wajib diisi.',
        'no_handphone.max' => 'Nomor HP maksimal 15 karakter.',
    ];

    public function render()
    {
        $query = User::query();

        if($this->showDeleted) {
            $query->where('isDeleted', true);
        } else {
            $query->where('isDeleted', false);
        }
        if(!empty($this->searchNama)) {
            $query->where('nama', 'like', '%' . $this->searchNama . '%');
        }
        if($this->searchUsername) {
            $query->where('username', 'like', '%' . $this
            ->searchUsername . '%');
        }if($this->searchNoHp) {
            $query->where('no_handphone', 'like', '%' . $this->searchNoHp . '%');
        }
        if($this->filterUserLevel) {
            $query->where('user_level', $this->filterUserLevel);
        }   

        $users = $query->paginate($this->perPage);
        return view('livewire.admin.users.manage-users', compact('users'));
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->nama = $user->nama;
        $this->user_level = $user->user_level;
        $this->username = $user->username;
        $this->alamat = $user->alamat;
        $this->no_handphone = $user->no_handphone;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'user_level' => 'required|in:admin,officer',
            'alamat' => 'required|string',
            'no_handphone' => 'required|string|max:15',
        ];

        if (!$this->user_id) {
            $rules['username'] = 'required|string|unique:users,username';
            $rules['password'] = 'required|min:6';
        } else {
            $rules['username'] = 'required|string|unique:users,username,' . $this->user_id;
            $rules['password'] = 'nullable|min:6';
        }

        $this->validate($rules);

        if ($this->user_id) {
            $user = User::findOrFail($this->user_id);
            $user->update([
                'nama' => $this->nama,
                'user_level' => $this->user_level,
                'username' => $this->username,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
                'alamat' => $this->alamat,
                'no_handphone' => $this->no_handphone,
            ]);
        } else {
            User::create([
                'nama' => $this->nama,
                'user_level' => $this->user_level,
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'alamat' => $this->alamat,
                'no_handphone' => $this->no_handphone,
            ]);
        }

        session()->flash('success', $this->user_id ? 'User diperbarui' : 'User ditambahkan');
        $this->closeModal();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->update(['isDeleted' => true]);

        session()->flash('success', 'User berhasil dihapus');
    }

    public function restore($id)
    {
        $user = User::findOrFail($id);
        $user->update(['isDeleted' => false]);

        session()->flash('success', 'User berhasil dipulihkan');
    }

    public function toggleDeleted()
    {
        $this->showDeleted = !$this->showDeleted;
        $this->resetPage();

    }

    public function openModal() { $this->isModalOpen = true; }
    public function closeModal() { $this->isModalOpen = false; }

    private function resetFields()
    {
        $this->user_id = null;
        $this->nama = '';
        $this->user_level = '';
        $this->username = '';
        $this->password = '';
        $this->alamat = '';
        $this->no_handphone = '';
    }
}
