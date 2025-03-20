<div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 text-center">
            {{ $showDeleted ? 'History Customer' : 'Manage Customer' }}
        </h2>    

        @if(session('success'))
            <div class="mb-4 text-green-500">{{ session('success') }}</div>
        @endif

        <div class="flex justify-end mt-4 space-x-2">
            @if($showDeleted)
                <button wire:click="toggleHistory" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    🔙 Kembali ke Customer Aktif
                </button>
            @else
            <div class="flex justify-end space-x-2 mb-4">
                <button wire:click="openCreateModal"
                    class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700">
                    + Tambah Pelanggan
                </button>
                <button wire:click="toggleHistory" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    🕒 History Customers
                </button>
            </div>
            @endif
        </div>

        <!-- Filter Search -->
        <div class="flex justify-between items-center mb-4 mt-6 bg-gray-300 dark:bg-gray-900 p-4 rounded-lg shadow-md">
            <div class="w-full flex gap-3">
                <input type="text" wire:model.live="search" 
                    class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Cari Nama Pelanggan">
                
                <input type="text" wire:model.live="searchPhone" 
                    class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Cari Nomor HP">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto mt-6 rounded-lg">

        <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
            <thead class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-6 py-2">Nama</th>
                    <th class="px-6 py-2">Alamat</th>
                    <th class="px-6 py-2">Nomor HP</th>
                    <th class="px-6 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 dark:text-white">
                @foreach($customers as $customer)
                <tr>
                    <td class="px-6 py-2">{{ $customer->nama_pelanggan }}</td>
                    <td class="px-6 py-2">{{ $customer->alamat_pelanggan }}</td>
                    <td class="px-6 py-2">{{ $customer->nomor_hp }}</td>
                    <td class="px-6 py-2 text-end">
                        @if(!$showDeleted)
                        <button wire:click="openEditModal({{ $customer->id }})"
                            class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                            Edit
                        </button>
                        
                        <button onclick="confirmDelete({{ $customer->id }})"
                            class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                            Hapus
                        </button>
                    @else
                        <button onclick="confirmRestore({{ $customer->id }})"
                            class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                            Pulihkan
                        </button>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        {{ $customers->links() }}
    </div>
    
    <!-- Modal Create -->
    @if($isOpenCreate)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-lg font-semibold mb-4 dark:text-white text-center">Tambah Pelanggan</h2>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan</label>
                @error('nama_pelanggan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                <input type="text" wire:model.live="nama_pelanggan"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan Nama Pelanggan">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                @error('alamat_pelanggan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                <input type="text" wire:model.live="alamat_pelanggan"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white "
                    placeholder="Masukkan Alamat Pelanggan">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor HP</label>
                @error('nomor_hp') 
                <p class="text-danger text-red-500 text-sm">{{ $message }}</p> 
                @enderror
                <input type="text" wire:model.live="nomor_hp"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan Nomor HP">

                </div>
            <div class="flex justify-between mt-6">
                <button wire:click="createCustomer" class="bg-green-500 text-white px-6 py-2 rounded">Simpan</button>
                <button wire:click="$set('isOpenCreate', false)" class="bg-gray-500 text-white px-6 py-2 rounded ml-2">Batal</button>

            </div>
        </div>
    </div>
    @endif

    <!-- Modal Edit -->
    @if($isOpenEdit)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-lg font-semibold mb-4 text-center dark:text-white">Edit Pelanggan</h2>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-white">Nama Pelanggan</label>
                @error('nama_pelanggan') <span class="text-red-500">{{ $message }}</span> @enderror
                <input type="text" wire:model="nama_pelanggan" 
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
    
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-white">Alamat</label>
                @error('alamat_pelanggan') <span class="text-red-500">{{ $message }}</span> @enderror
                <input type="text" wire:model="alamat_pelanggan" 
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
    
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-white">Nomor HP</label>
                @error('nomor_hp') <span class="text-red-500">{{ $message }}</span> @enderror
                <input type="text" wire:model="nomor_hp" inputmode="numeric" pattern="[0-9]*"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>
    
            <div class="flex justify-between">
                <button wire:click="updateCustomer" class="bg-blue-500 text-white px-6 py-2 rounded">Update</button>
                <button wire:click="$set('isOpenEdit', false)" class="bg-gray-500 text-white px-6 py-2 rounded ml-2">Batal</button>
                </button>
            </div>
        </div>
    </div>
    @endif

    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')) {
                Livewire.dispatch('confirmDeleteCustomer', { id: id });
            }
        }
    
        function confirmRestore(id) {
            if (confirm('Apakah Anda yakin ingin mengembalikan pelanggan ini?')) {
                Livewire.dispatch('confirmRestoreCustomer', { id: id });
            }
        }
    </script>
    