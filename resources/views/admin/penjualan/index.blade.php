<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Riwayat Transaksi</h2>

            <div class="overflow-x-auto mt-6">
                <table class="w-full border rounded-md bg-white dark:bg-gray-900">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="px-4 py-2">Nomor Transaksi</th>
                            <th class="px-4 py-2">Pelanggan</th>
                            <th class="px-4 py-2">Total Bayar</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item->id }}</td>
                            <td class="px-4 py-2">{{ $item->customer->nama_pelanggan ?? 'Guest' }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($item->total_bayar, 2) }}</td>
                            <td class="px-4 py-2">{{ $item->tanggal_penjualan }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.penjualan.show', $item->id) }}" class="px-3 py-1 bg-indigo-500 text-white rounded-md">Lihat Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginator -->
            <div class="mt-4 flex justify-end">
                {{ $penjualan->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
