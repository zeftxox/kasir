<div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 text-center">
            {{ $showDeleted ? 'History Produk (Dihapus)' : 'Manage Produk' }}
        </h2>
        @if(session('success'))
            <p class="mt-4 text-green-500">{{ session('success') }}</p>
        @elseif(session('error'))
            <p class="mt-4 text-red-500">{{ session('error') }}</p>
        @endif

        <div class="flex justify-end mt-4 space-x-2">
            @if($showDeleted)
                <button wire:click="toggleHistory" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Kembali ke Produk Aktif
                </button>
            @else
            <div class="flex justify-end space-x-2 mb-4">
                <button wire:click="openCreateModal"
                    class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700">
                    Tambah Produk
                </button>
                <button wire:click="toggleHistory" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Deleted Produk
                </button>
            </div>
            @endif
        </div>

        <!-- Filter -->
        <div class="mt-6 bg-gray-300 dark:bg-gray-900 p-4 rounded-lg shadow-md">
            <div class="flex flex-wrap items-center gap-3 w-full">
                <input type="text" wire:model.live="searchNama" 
                    class="pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded-md w-1/6 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-500"
                    placeholder="Nama Produk">
                    
                <input type="text" wire:model.live="searchKategori"
                    class="pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded-md w-1/6 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-500"
                    placeholder="Kategori">
                    
                <input type="text" wire:model.live="searchBarcode"
                    class="pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded-md w-1/6 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-500"
                    placeholder="Barcode">
                    
                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg w-1/6">
                    <input type="number" wire:model.live="hargaMin" class="p-2 w-1/2 border-r rounded-s-md dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-500" placeholder="Min">
                    <input type="number" wire:model.live="hargaMax" class="p-2 w-1/2 rounded-e-md dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-500" placeholder="Max">
                </div>
                    
                <div class="relative flex items-center border border-gray-300 dark:border-gray-600 rounded-lg w-1/6">
                    <input type="number" wire:model.live="stok" class="p-2 w-3/4 rounded-s-md dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-500" placeholder="Stok">
                    <select wire:model.live="stokOp" class="w-1/4 p-2 bg-gray-200 dark:bg-gray-700 dark:text-white rounded-e-md focus:ring focus:ring-indigo-500">
                        <option value="lebih_besar">🔼</option>
                        <option value="lebih_kecil">🔽</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Produk -->
        <div class="overflow-x-auto mt-6 rounded-lg">
            <table class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-800">
                <thead class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Produk</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Harga Beli</th>
                        <th class="px-6 py-3 text-left">Harga Jual</th>
                        <th class="px-6 py-3 text-left">Stok</th>
                        <th class="px-6 py-3 text-left">Barcode</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($products as $product)
                        <tr>
                            <td class="px-6 py-4 dark:text-white">{{ $product->nama_produk }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $product->category->kategori ?? '' }}</td>
                            <td class="px-6 py-4 dark:text-white">Rp {{ number_format($product->harga_beli, 2) }}</td>
                            <td class="px-6 py-4 dark:text-white">Rp {{ number_format($product->harga_jual, 2) }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $product->stok }}</td>
                            <td class="px-6 py-4 dark:text-white">{{ $product->barcode }}</td>
                            <td class="px-6 py-4 dark:text-white flex space-x-2">
                                @if(!$showDeleted)
                                    <button wire:click="openEditModal({{ $product->id }})" 
                                        class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                        Edit
                                    </button>
                                    <button onclick="confirmDelete({{ $product->id }})"
                                        class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                        Delete
                                    </button>
                                @else
                                    <button onclick="confirmRestore({{ $product->id }})"
                                        class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                                        Pulihkan
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-between mt-4">
            <div class="flex items-center space-x-2">
                <label for="perPage" class="text-gray-700 dark:text-gray-300">Tampilkan</label>
                <select wire:model.live="perPage"
                    class="p-2 pr-6 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    @if($isOpenCreate)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/3 dark:text-white">
                <h2 class="text-lg font-semibold mb-4 text-center dark:text-white">Tambah Produk</h2>

                <label>Nama Produk</label>
                @error('nama_produk') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="text" wire:model="nama_produk" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <label>Kategori</label>
                @error('id_kategori') <p class="text-red-500">{{ $message }}</p> @enderror
                <select wire:model="id_kategori" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->kategori }}</option>
                    @endforeach
                </select>

                <label>Harga Beli</label>
                @error('harga_beli') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="number" wire:model="harga_beli" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <label>Harga Jual</label>
                @error('harga_jual') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="number" wire:model="harga_jual" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <label>Stok</label>
                @error('stok') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="number" wire:model="stok" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <label>Barcode</label>
                @error('barcode') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="text" wire:model="barcode" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <div class="flex justify-end mt-4">
                    <button wire:click="createProduct" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                    <button wire:click="$set('isOpenCreate', false)" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Edit -->
    @if($isOpenEdit)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-1/3 dark:text-white">
            <h2 class="text-lg font-semibold mb-4 text-center dark:text-white">Edit Produk</h2>

                <label>Nama Produk</label>
                @error('nama_produk') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="text" wire:model="nama_produk" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <label>Kategori</label>
                @error('id_kategori') <p class="text-red-500">{{ $message }}</p> @enderror
                <select wire:model="id_kategori" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->kategori }}</option>
                    @endforeach
                </select>

                <label>Harga Beli</label>
                @error('harga_beli') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="number" wire:model="harga_beli" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <label>Harga Jual</label>
                @error('harga_jual') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="number" wire:model="harga_jual" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <label>Stok</label>
                @error('stok') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="number" wire:model="stok" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <label>Barcode</label>
                @error('barcode') <p class="text-red-500">{{ $message }}</p> @enderror
                <input type="text" wire:model="barcode" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">

                <div class="flex justify-end mt-4">
                    <button wire:click="updateProduct" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                    <button wire:click="$set('isOpenEdit', false)" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</button>
                </div>
            </div>
        </div>
    @endif
</div>


<script>
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')) {
            Livewire.dispatch('confirmDeleteProduct', { id: id });
        }
    }

    function confirmRestore(id) {
        if (confirm('Apakah Anda yakin ingin mengembalikan pelanggan ini?')) {
            Livewire.dispatch('confirmRestoreProduct', { id: id });
        }
    }
</script>
