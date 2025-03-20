<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Manage Kategori</h2>

        <!-- Menampilkan Pesan Sukses -->
        @if(session('success'))
            <p class="mt-4 text-green-500">{{ session('success') }}</p>
        @endif

        <div class="flex justify-end mt-4">
            <button wire:click="openModal" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700">
                + Tambah Kategori
            </button>
        </div>

        <div class="flex justify-between items-center mb-4 mt-6 bg-gray-300 dark:bg-gray-900 p-4 rounded-lg shadow-md">
            <div class="w-full flex gap-3">
                <input type="text" wire:model.live="search" 
                    class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Cari Kategori">
            </div>
        </div>

        <div class="overflow-x-auto mt-6 rounded-lg">
            <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
                <thead class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-center">
                    <tr>
                        <th class="px-6 py-3 text-sm font-medium">Kategori</th>
                        <th class="px-6 py-3 text-sm font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($categories as $category)
                        <tr>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $category->kategori }}</td>
                            <td class="px-6 py-4 flex space-x-2 justify-end">
                                <button wire:click="edit({{ $category->id }})" 
                                        class="px-3 py-1 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600">
                                    Edit
                                </button>
                                <button onclick="confirmDelete({{ $category->id }})" 
                                        class="px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Popup Modal -->
        @if($isOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-xl font-semibold mb-4">{{ $category_id ? 'Edit Kategori' : 'Tambah Kategori' }}</h2>
                <input type="text" wire:model="kategori" class="w-full border-gray-300 rounded-md p-2 mb-4" placeholder="Nama Kategori">
                @error('kategori') <p class="text-red-500">{{ $message }}</p> @enderror
                
                <div class="flex justify-end space-x-2">
                    <button wire:click="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded-md">Batal</button>
                    @if($category_id)
                        <button wire:click="update" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update</button>
                    @else
                        <button wire:click="store" class="px-4 py-2 bg-green-600 text-white rounded-md">Simpan</button>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')) {
            Livewire.dispatch('confirmDeleteCategories', { id: id });
        }
    }
</script>