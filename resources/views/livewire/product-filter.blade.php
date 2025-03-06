<div>
    <!-- Form Filter -->
    <div class="bg-gray-200 dark:bg-gray-700 p-4 rounded-md mb-4 mt-4">
        <div class="flex flex-wrap gap-4">

            <!-- Filter Kategori -->
            <div>
                <label class="text-gray-700 dark:text-gray-300">Kategori</label>
                <select wire:model="category" class="p-2 border rounded-md dark:bg-gray-900 dark:border-gray-700">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Harga -->
            <div>
                <label class="text-gray-700 dark:text-gray-300">Harga Min</label>
                <input type="number" wire:model="min_price" placeholder="Min Harga"
                       class="p-2 border rounded-md dark:bg-gray-900 dark:border-gray-700">
            </div>
            <div>
                <label class="text-gray-700 dark:text-gray-300">Harga Max</label>
                <input type="number" wire:model="max_price" placeholder="Max Harga"
                       class="p-2 border rounded-md dark:bg-gray-900 dark:border-gray-700">
            </div>

            <!-- Filter Stok -->
            <div>
                <label class="text-gray-700 dark:text-gray-300">Stok Min</label>
                <input type="number" wire:model="min_stock" placeholder="Min Stok" value="30"
                       class="p-2 border rounded-md dark:bg-gray-900 dark:border-gray-700">
            </div>

            <!-- Filter Barcode -->
            <div>
                <label class="text-gray-700 dark:text-gray-300">Barcode</label>
                <input type="text" wire:model="barcode" placeholder="Cari Barcode"
                       class="p-2 border rounded-md dark:bg-gray-900 dark:border-gray-700">
            </div>
        </div>
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
                        <td class="px-6 py-4">{{ $product->nama_produk }}</td>
                        <td class="px-6 py-4">{{ $product->category->kategori }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($product->harga_beli, 2) }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($product->harga_jual , 2) }}</td>
                        <td class="px-6 py-4">{{ $product->stok }}</td>
                        <td class="px-6 py-4">{{ $product->barcode }}</td>
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
