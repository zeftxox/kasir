<div>
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Filter Produk</h2>

    <div class="bg-gray-200 dark:bg-gray-700 p-4 rounded-md mb-4 mt-4">
        <div class="flex flex-wrap gap-4">
            <div>
                <label class="text-gray-700 dark:text-gray-300">Kategori</label>
                <select wire:model="category" class="p-2 border rounded-md dark:bg-gray-900 dark:border-gray-700">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-gray-700 dark:text-gray-300">Harga Min</label>
                <input type="number" wire:model="min_price" class="p-2 border rounded-md dark:bg-gray-900 dark:border-gray-700">
            </div>
            <div>
                <label class="text-gray-700 dark:text-gray-300">Harga Max</label>
                <input type="number" wire:model="max_price" class="p-2 border rounded-md dark:bg-gray-900 dark:border-gray-700">
            </div>
        </div>
    </div>

    <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Barcode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->nama_produk }}</td>
                    <td>{{ $product->category->kategori }}</td>
                    <td>Rp {{ number_format($product->harga_beli, 2) }}</td>
                    <td>Rp {{ number_format($product->harga_jual, 2) }}</td>
                    <td>{{ $product->stok }}</td>
                    <td>{{ $product->barcode }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
