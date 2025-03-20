<x-app-layout>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6" id="printArea">
            <!-- Header Toko -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Detail Transaksi</h2>
                <p class="text-gray-600 dark:text-gray-400">Struk Pembelian - {{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d M Y, H:i') }}</p>
                <p class="text-gray-600 dark:text-gray-400">Nomor Invoice - INV/{{ $penjualan->id }}/{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('Y') }}</p>
            </div>

            <div class="flex flex-auto justify-between container-user">
                <!-- Informasi Customer -->
                <div class="mt-4 dark:text-white">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Informasi Customer</h3>
                    <p>Nama: <strong>{{ $penjualan->customer->nama_pelanggan ?? '-' }}</strong></p>
                    <p>Alamat: <strong>{{ $penjualan->customer->alamat_pelanggan ?? '-' }}</strong></p>
                    <p>No HP: <strong>{{ $penjualan->customer->nomor_hp ?? '-' }}</strong></p>
                </div>

                <!-- Informasi Petugas Kasir -->
                <div class="mt-4 dark:text-white">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Informasi Petugas</h3>
                    <p>Nama: <strong>{{ $penjualan->user->nama }}</strong></p>
                    <p>Alamat: <strong>{{ $penjualan->user->alamat ?? '-' }}</strong></p>
                    <p>No HP: <strong>{{ $penjualan->user->no_handphone ?? '-' }}</strong></p>
                </div>
            </div>

            <!-- Tabel Produk dalam Transaksi -->
            <div class="mt-6 overflow-x-auto">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Daftar Produk</h3>
                <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 mt-2 text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <tr class="border border-gray-500">
                            <th class="px-4 py-2 dark:text-white text-center">No</th>
                            <th class="px-4 py-2 dark:text-white text-left">Nama Produk</th>
                            <th class="px-4 py-2 dark:text-white text-right">Harga Jual</th>
                            <th class="px-4 py-2 dark:text-white text-center">Qty</th>
                            <th class="px-4 py-2 dark:text-white text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 dark:text-white">
                        @foreach($penjualan->detailPenjualan as $index => $item)
                        <tr class="">
                            <td class="px-4 py-2 dark:text-white text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 dark:text-white " >{{ $item->product->nama_produk }}</td>
                            <td class="px-4 py-2 dark:text-white text-right">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 dark:text-white text-center">{{ $item->qty }}</td>
                            <td class="px-4 py-2 dark:text-white text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Ringkasan Transaksi -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Ringkasan Transaksi</h3>
                <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 mt-2 text-sm">
                    <tbody>
                        <tr class="border border-gray-500">
                            <td class="px-4 py-2 dark:text-white">Subtotal</td>
                            <td class="px-4 py-2 dark:text-white text-right">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border border-gray-500">
                            <td class="px-4 py-2 dark:text-white">Diskon</td>
                            <td class="px-4 py-2 dark:text-white text-right">Rp {{ number_format(($penjualan->total_harga * ($penjualan->discount / 100)), 0, ',', '.') }} ({{ $penjualan->discount }}%)</td>
                        </tr>
                        <tr class="border border-gray-500">
                            <td class="px-4 py-2 dark:text-white font-semibold">Total Bayar</td>
                            <td class="px-4 py-2 dark:text-white text-right font-semibold">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border border-gray-500">
                            <td class="px-4 py-2 dark:text-white font-semibold">Kembalian</td>
                            <td class="px-4 py-2 dark:text-white text-right font-semibold">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
            <!-- Tombol Cetak Struk -->
            <div class="mt-6 flex justify-between items-center">
                <div class="flex-1 flex justify-center">
                    <button onclick="printInvoice()"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        🖨️ Cetak Struk
                    </button>
                </div>

                <a href="{{ route('admin.penjualan.index') }}" 
                class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-md hover:bg-gray-600">
                 Batal
                </a>            
            </div>
    </div>

    <!-- Script untuk Cetak -->
    <script>
        function printInvoice() {
            var printContents = document.getElementById('printArea').innerHTML;
            var originalContents = document.body.innerHTML;
            
            // Buat tampilan cetak
            document.body.innerHTML = `
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            text-align: center;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: left;
                        }
                        .no-print {
                            display: none;
                        }
                        .container-user{
                            display:flex;
                            justify-content: space-between;
                            text-align: left;
                        }
                    </style>
                </head>
                <body>
                    ${printContents}
                </body>
            `;
            // Kembalikan tampilan normal
            printWindow = window.open("","_blank","width=500, heigt=600");
            printWindow.document.write(document.body.innerHTML)
            printWindow.document.close();
            printWindow.print()
            document.body.innerHTML = originalContents;
        }

    </script>
</x-app-layout>
