<div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 text-center">Riwayat Transaksi</h2>
        @if(session('error'))
            <p class="mt-4 text-red-500">{{ session('error') }}</p>
        @endif
        @if(session('success'))
            <p class="mt-4 text-green-500">{{ session('success') }}</p>
        @endif

        <div class="mt-4 flex justify-end">
            <button wire:click="toggleHistory" 
                class="px-4 py-2 dark:text-white rounded-md"
                :class="{ 'bg-gray-500 hover:bg-gray-600': !showDeleted, 'bg-red-500 hover:bg-red-600': showDeleted }">
            </button>
        </div>

        <!-- 🔹 Filter -->
        <div class="mt-6 bg-gray-300 dark:bg-gray-900 p-4 rounded-lg shadow-md flex gap-3 w-full">
            <div class="w-1/3">
                <label class="text-sm font-medium text-gray-700 dark:text-white">🔍 Cari Pelanggan</label>
                <input type="text" wire:model.live="searchPelanggan" 
                    class="w-full px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" 
                    placeholder="Nama Pelanggan...">
            </div>

            <div class="w-1/3">
                <label class="text-sm font-medium text-gray-700 dark:text-white">📅 Filter Tanggal</label>
                <input type="date" wire:model.live="searchTanggal" 
                    class="w-full px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="w-1/3">
                <label class="text-sm font-medium text-gray-700 dark:text-white">💰 Total Bayar (Min)</label>
                <input type="number" wire:model.live="searchTotalBayar" 
                    class="w-full px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" 
                    placeholder="Masukkan Min Total Bayar">
            </div>
        </div>

        <!-- 🔹 Tabel Data -->
        <div class="overflow-x-auto mt-6 rounded-md">
            <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 ">
                <thead class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2">Nomor Transaksi</th>
                        <th class="px-4 py-2">Pelanggan</th>
                        <th class="px-4 py-2">Total Bayar</th>
                        <th class="px-4 py-2">Tanggal Transaksi</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700  dark:text-white">
                    @foreach($penjualan as $item)
                    <tr>
                        <td class="px-4 py-2 dark:text-white">{{ $item->id }}</td>
                        <td class="px-4 py-2 dark:text-white">{{ $item->customer->nama_pelanggan ?? 'Guest' }}</td>
                        <td class="px-4 py-2 dark:text-white">Rp {{ number_format($item->total_bayar, 2) }}</td>
                        <td class="px-4 py-2 dark:text-white">{{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d M Y') }}</td>
                        <td class="px-4 py-2 flex justify-center space-x-2">
                            @if(Auth::user()->user_level === 'admin' || $item->id_user === Auth::id())
                                @if(!$showDeleted)
                                <a href="{{ route('admin.penjualan.detail', $item->id) }}" 
                                    class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                    Edit
                                </a>
                                <a href="{{ route('admin.penjualan.show', $item->id) }}" 
                                    class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                                    View
                                </a>
                                @else
                                @endif
                                
                                @if(Auth::user()->user_level === 'admin')
                                    @if(!$showDeleted)
                                    <button wire:click="deleteTransaction({{ $item->id }})"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')"
                                        class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                        Hapus
                                    </button>
                                    @else
                                    <button wire:click="restoreTransaction({{ $item->id }})"
                                        onclick="return confirm('Apakah Anda ingin memulihkan transaksi ini?')"
                                        class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                                        Pulihkan
                                    </button>
                                    @endif
                                @endif
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 🔹 Paginator -->
        <div class="mt-4 flex justify-between items-center">
            <div>
                <label for="perPage" class="text-gray-700 dark:text-gray-300">Tampilkan</label>
                <select wire:model.live="perPage" id="perPage" 
                    class="p-2 border rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>            
            <div>
                {{ $penjualan->links() }}
            </div>
        </div>
    </div>
    <div class="mt-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md flex gap-3 w-full">
        <!-- Filter Tanggal Mulai -->
        <div class="w-1/3">
            <label class="text-sm font-medium text-gray-700 dark:text-white">📅 Tanggal Mulai</label>
            <input type="date" wire:model="tanggalMulai"
                class="w-full px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
        </div>
    
        <!-- Filter Tanggal Akhir -->
        <div class="w-1/3">
            <label class="text-sm font-medium text-gray-700 dark:text-white">📅 Tanggal Akhir</label>
            <input type="date" wire:model="tanggalAkhir"
                class="w-full px-6 py-2 border rounded-lg focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
        </div>
    
        <!-- Tombol Cetak -->
        <div class="w-1/3 flex items-end gap-4">
            <button wire:click="printReportPDF"
                class="w-full px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                🖨️ Cetak PDF
            </button>
            <button wire:click="exportExcel"
                class="w-full px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                🖨️ Cetak Excel
            </button>
        </div>
    </div>
    
</div>

<!-- 🔹 Script Konfirmasi Hapus -->
<script>
    function confirmDelete(id) {
        if(confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
            Livewire.emit('deleteTransaction', id);
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('refreshTable', () => {
        location.reload(); // Untuk memastikan daftar pelanggan langsung diperbarui setelah delete
    });
});
</script>
