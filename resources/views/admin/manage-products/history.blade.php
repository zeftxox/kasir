<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">History Produk</h2>

            <div class="flex justify-end mt-4">
                <a href="{{ route('admin.manage-products.index') }}" 
                   class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700">
                    🔙 Kembali ke Manage Produk
                </a>
            </div>

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
                        @foreach($deletedProducts as $product)
                            <tr>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->nama_produk }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->category->kategori }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">Rp {{ number_format($product->harga_beli, 2) }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">Rp {{ number_format($product->harga_jual , 2) }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->stok }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $product->barcode }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <form method="POST" action="{{ route('admin.manage-products.restore', $product->id) }}" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                                onclick="return confirm('Apakah Anda ingin mengembalikan produk ini?')" 
                                                class="px-3 py-1 bg-green-500 text-white text-sm font-medium rounded-md hover:bg-green-600">
                                            🔄 Restore
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
