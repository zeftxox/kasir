<div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 text-center">
            {{ $showDeleted    ? 'History Users' : 'Manage Users' }}
        </h2>

        @if(session()->has('success'))
            <p class="mt-4 text-green-500">{{ session('success') }}</p>
        @endif

        <div class="flex justify-end mt-4 space-x-2">
            @if(!$showDeleted)
            <button wire:click="create" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-600">
                + Tambah User
            </button>
            @endif
            <button wire:click="toggleDeleted" class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-md shadow-md hover:bg-gray-700">
                {{ $showDeleted ? 'Lihat Aktif' : 'Lihat Terhapus' }}
            </button>
        </div>
        <div class="flex justify-between items-center mb-4 mt-6 bg-gray-300 dark:bg-gray-900 p-4 rounded-lg shadow-md">
            <div class="w-full flex gap-4">
                <input type="text" wire:model.live="searchNama" placeholder="Cari Nama" class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <input type="text" wire:model.live="searchUsername" placeholder="Cari Username" class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <input type="text" wire:model.live="searchNoHp" placeholder="Cari No HP" class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                <select wire:model.live="filterUserLevel" class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 ">
                    <option value="">-- Pilih User Level --</option>
                    <option value="admin">Admin</option>
                    <option value="officer">Officer</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto mt-6 rounded-lg">

            <table class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-800">
                <thead class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-2">Nama</th>
                        <th class="px-6 py-2">User Level</th>
                        <th class="px-6 py-2">Username</th>
                        <th class="px-6 py-2">Alamat</th>
                        <th class="px-6 py-2">No HP</th>
                        <th class="px-6 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 dark:text-white">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-2">{{ $user->nama }}</td>
                            <td class="px-6 py-2">{{ ucfirst($user->user_level) }}</td>
                            <td class="px-6 py-2">{{ $user->username }}</td>
                            <td class="px-6 py-2">{{ $user->alamat }}</td>
                            <td class="px-6 py-2">{{ $user->no_handphone }}</td>
                            <td class="px-6 py-2 flex space-x-2">
                                @if($showDeleted)
                                <button onclick="confirmRestore({{ $user->id }})" class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">
                                    Restore
                                </button>
                                @else
                                    <button wire:click="edit({{ $user->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600">
                                        Edit
                                    </button>
                                    <button onclick="confirmDelete({{ $user->id }})" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                                        Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
         </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Popup -->
    @if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/3 dark:text-white">
            <h3 class="text-xl font-semibold mb-4 text-center">{{ $user_id ? 'Edit User' : 'Tambah User' }}</h3>
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama</label>
                    @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <input type="text" wire:model="nama" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div class="mb-3">
                    <label class="block text-sm font-medium">User Level</label>
                    @error('user_level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <select wire:model="user_level" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="">--Pilih Level--</option>
                        <option value="admin">Admin</option>
                        <option value="officer">Officer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Username</label>
                    @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <input type="text" wire:model="username" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Password</label>
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <input type="password" wire:model="password" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                        placeholder="{{ $user_id ? 'Abaikan jika tidak ingin diubah' : 'Masukkan password' }}">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Alamat</label>
                    @error('alamat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <input type="text" wire:model="alamat" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">No Handphone</label>
                    @error('no_handphone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <input type="text" wire:model="no_handphone" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="closeModal" class="px-6 py-2 bg-gray-500 text-white rounded-md">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">
                        {{ $user_id ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

<script>
     function confirmDelete(id) {
         if (confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')) {
             Livewire.dispatch('confirmDeleteUsers', { id: id });
         }
     }

     function confirmRestore(id) {
         if (confirm('Apakah Anda yakin ingin mengembalikan pelanggan ini?')) {
             Livewire.dispatch('confirmRestoreUsers', { id: id });
         }
     }
</script>