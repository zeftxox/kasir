<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Manage Produk</h2>

            @if(session('success'))
                <p class="mt-4 text-green-500">{{ session('success') }}</p>
            @endif

            @livewire('product-filter')

            <!-- Tombol Tambah Produk & History -->
            <div class="flex justify-end mt-4">
                <a href="{{ route('admin.manage-products.create') }}" 
                   class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700">
                    + Tambah Produk
                </a>

                <a href="{{ route('admin.manage-products.history') }}" 
                   class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-md shadow-md hover:bg-gray-700 ml-2">
                    🕒 History Produk
                </a>
            </div>
            

            <!-- Tabel Produk -->
            <div class="overflow-x-auto mt-6">
                <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Kategori</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Harga Beli</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Harga Jual</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Stok</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Barcode</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($products as $product)
                            <tr>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->nama_produk }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->category->kategori }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">Rp {{ number_format($product->harga_beli, 2) }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">Rp {{ number_format($product->harga_jual , 2) }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->stok }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->barcode }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('admin.manage-products.edit', $product->id) }}" 
                                       class="px-3 py-1 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.manage-products.destroy', $product->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" 
                                                class="px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
