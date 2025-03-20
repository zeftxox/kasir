<div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 text-center">Detail Transaksi</h2>

        <div class="flex justify-between">
            <!-- Informasi Customer -->
            <div class="mt-6 dark:text-white">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Informasi Customer</h3>
                <p>Nama: <strong>{{ $penjualan->customer->nama_pelanggan ?? 'Guest' }}</strong></p>
                <p>Alamat: <strong>{{ $penjualan->customer->alamat_pelanggan ?? '-' }}</strong></p>
                <p>No HP: <strong>{{ $penjualan->customer->nomor_hp ?? '-' }}</strong></p>
            </div>

            <!-- Informasi Petugas -->
            <div class="mt-4 dark:text-white">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Informasi Petugas (Kasir)</h3>
                <p>Nama: <strong>{{ $penjualan->user->nama }}</strong></p>
                <p>Alamat: <strong>{{ $penjualan->user->alamat ?? '-' }}</strong></p>
                <p>No HP: <strong>{{ $penjualan->user->no_handphone ?? '-' }}</strong></p>
            </div>
        </div>

        <!-- Tabel Produk -->
        <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 mt-4">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga Jual</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody class="dark:text-white text-center">
                @foreach($cart as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama_produk'] }}</td>
                    <td>Rp {{ number_format($item['harga_jual'], 0, ',', '.') }}</td>
                    <td>
                        <input type="number" class="bg-gray-500 w-12" wire:model.live="cart.{{ $index }}.qty" min="1" class="border p-2 w-16">
                    </td>
                    <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Ringkasan Transaksi -->
        <div class="mt-6 bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-md">
            <div class="gap-4 mt-2 dark:text-white">
                <div class="flex justify-between dark:text-white">
                    <span>Subtotal</span>
                    <div class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                </div>

                <div class="flex justify-between dark:text-white">
                    <span>Diskon (%)</span>
                    <input type="number" wire:model.live="discount"
                        class="w-24 p-1 border rounded-md focus:ring focus:ring-indigo-500 dark:text-gray-900"
                        min="0" max="100" step="1" value="{{ old('discount', $discount) }}">
                </div>
                <div class="pb-1 flex justify-between dark:text-white">
                    <span>Potongan Diskon</span>
                    <div class="text-right">Rp {{ number_format((float) $subtotal * ((float) $discount / 100), 0, ',', '.') }}</div>
                </div>
                

                <div class="flex justify-between dark:text-white">
                    <span>Penyesuaian</span>
                    <input type="number" wire:model.live="penyesuaian"
                        class="w-24 p-1 border rounded-md focus:ring focus:ring-indigo-500  dark:text-gray-900"
                        value="{{ old('penyesuaian', $penyesuaian) }}">
                </div>

                <div class="flex justify-between mt-2 ">
                    <span>Total Harga</span>
                    <div class="text-right">Rp {{ number_format($total_harga, 0, ',', '.') }}</div>
                </div>

                <div class="flex justify-between mt-2 ">
                    <span>Total Bayar</span>
                    <input type="number" wire:model.live="total_bayar"
                    class="w-30 p-1 border rounded-md focus:ring focus:ring-indigo-500 dark:text-gray-900" 
                    min="0" value="{{ old('total_bayar', $total_bayar) }}">
                </div>

                <div>Kembalian:</div>
                <div class="text-right text-green-500 font-semibold">Rp {{ number_format($kembalian, 0, ',', '.') }}</div>
            </div>
        </div>


        <!-- Tombol Simpan -->
        <div class="mt-6 flex justify-center">
            <button wire:click="saveTransaction" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                ✅ Simpan Perubahan
            </button>
            
        </div>
    </div>
</div>
