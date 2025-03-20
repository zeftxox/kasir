<div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 text-center">Kelola Produk (Officer)</h2>

        <!-- 🔍 Filter -->
        <div class="mt-6 bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-md flex gap-3 w-full">
            <input type="text" wire:model.live="searchNama"
                class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                placeholder="Cari Produk...">

            <input type="text" wire:model.live="searchKategori"
                class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                placeholder="Kategori">
            
            <input type="text" wire:model.live="searchBarcode"
                class="w-1/4 px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                placeholder="Barcode">
        </div>

        <!-- 📋 Tabel Produk -->
        <div class="mt-6 rounded-md">
            <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2">Nama Produk</th>
                        <th class="px-4 py-2">Kategori</th>
                        <th class="px-4 py-2">Barcode</th>
                        <th class="px-4 py-2">Harga Jual</th>
                        <th class="px-4 py-2">Harga Beli</th>
                        <th class="px-4 py-2">Stok</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-center dark:text-white">
                    @foreach($products as $product)
                    <tr>
                        <td class="px-4 py-2">{{ $product->nama_produk }}</td>
                        <td class="px-4 py-2">{{ $product->category->kategori ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $product->barcode }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <input type="number" wire:model.lazy="editStock.{{ $product->id }}"
                                class="w-16 p-1 border rounded-md text-center bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                                min="0" value="{{ $oldStock[$product->id] ?? $product->stok }}">
                        </td>
                        <td class="px-4 py-2">
                            <button wire:click="confirmUpdateStock({{ $product->id }})"
                                class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                                ✅ Update
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 🔹 Paginator -->
        <div class="mt-4 flex justify-between">
        <div>
            <label for="perPage" class="text-gray-700 dark:text-gray-300">Tampilkan</label>
            <select wire:model.live="perPage" id="perPage"
                class="p-2 border rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 ">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- 🔥 SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('showUpdateConfirmation', () => {
            Swal.fire({
                title: 'Konfirmasi Update Stok',
                text: "Apakah Anda yakin ingin memperbarui stok produk ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Perbarui!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('confirmUpdateStock');
                }
            });
        });

        Livewire.on('showSuccessMessage', ({ message }) => {
            Swal.fire('Sukses!', message, 'success');
        });
    });
</script>
