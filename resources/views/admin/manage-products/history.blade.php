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
            

            <!-- Container Filter -->
            <div class="mt-6 bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-md">
                <div class="flex flex-wrap items-center gap-3 w-full">

                    <!-- Filter Nama Produk -->
                    <div class="relative flex items-center w-full md:w-1/6">
                        <span class="absolute left-3 text-gray-500 dark:text-gray-400"></span>
                        <input type="text" id="filterNama" 
                            class="pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded-md w-full text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:ring focus:ring-indigo-500"
                            placeholder="🔎 Nama Produk">
                    </div>
                    
                    <!-- Filter Kategori -->
                    <div class="relative flex items-center w-full md:w-1/6">
                        {{-- <span class="left-3 text-gray-500 dark:text-gray-400"></span> --}}
                        <input type="text" id="filterKategori"
                            class="pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded-md w-full text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:ring focus:ring-indigo-500"
                            placeholder="📁 Kategori">
                    </div>

                    <!-- Filter Harga (Min - Max dalam 1 Box) -->
                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 w-full md:w-1/6">
                        <span class="px-2 text-gray-500 dark:text-gray-400">💰</span>
                        <input type="number" id="filterHargaMin" class="p-2 w-1/2 border-r border-gray-300 dark:border-gray-600 text-gray-700 dark:bg-gray-800 dark:text-gray-300 bg-transparent focus:ring focus:ring-indigo-500" placeholder="Min">
                        <input type="number" id="filterHargaMax" class="p-2 w-1/2 text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-transparent focus:ring focus:ring-indigo-500" placeholder="Max">
                    </div>

                    <!-- Filter Stok (Opsi dan Input dalam 1 Box) -->
                    <div class="relative flex items-center border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 w-full md:w-1/6">
                        <span class="px-2 text-gray-500 dark:text-gray-400">📦</span>
                        <input type="number" id="filterStok" class="p-2 w-3/4 text-gray-700 dark:text-gray-300 bg-transparent focus:ring dark:bg-gray-800 focus:ring-indigo-500" placeholder="Stok">
                        <select id="filterStokOpsi" class="w-1/4 p-2 bg-gray-200 dark:bg-gray-700 text-gray-700  dark:text-gray-300 rounded-md">
                            <option value="lebih_besar">🔼</option>
                            <option value="lebih_kecil">🔽</option>
                        </select>
                    </div>

                    <!-- Filter Barcode -->
                    <div class="relative flex items-center w-full md:w-1/6">
                        {{-- <span class="absolute left-3 text-gray-500 dark:text-gray-400"></span> --}}
                        <input type="text" id="filterBarcode"
                            class="pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded-md w-full text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:ring focus:ring-indigo-500"
                            placeholder="📌 Barcode">
                    </div>

                </div>
            </div>

            <div class="overflow-x-auto mt-6">
                <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800" id="productTable">
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
                            <tr class="product-row">
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 nama_produk">{{ $product->nama_produk }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 kategori">{{ $product->category->kategori }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 harga_beli">Rp {{ number_format($product->harga_beli, 2) }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 harga_jual">Rp {{ number_format($product->harga_jual , 2) }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 stok">{{ $product->stok }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 barcode">{{ $product->barcode }}</td>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const filters = {
                nama_produk: document.getElementById("filterNama"),
                kategori: document.getElementById("filterKategori"),
                hargaMin: document.getElementById("filterHargaMin"),
                hargaMax: document.getElementById("filterHargaMax"),
                stokOpsi: document.getElementById("filterStokOpsi"),
                stok: document.getElementById("filterStok"),
                barcode: document.getElementById("filterBarcode"),
            };
    
            function filterTable() {
                let rows = document.querySelectorAll(".product-row");
    
                rows.forEach(row => {
                    let nama_produk = row.querySelector(".nama_produk").innerText.toLowerCase();
                    let kategori = row.querySelector(".kategori").innerText.toLowerCase();
                    let harga_beli = parseFloat(row.querySelector(".harga_beli").innerText.replace(/[^\d.-]/g, ''));
                    let harga_jual = parseFloat(row.querySelector(".harga_jual").innerText.replace(/[^\d.-]/g, ''));
                    let stok = parseInt(row.querySelector(".stok").innerText);
                    let barcode = row.querySelector(".barcode").innerText.toLowerCase();
    
                    let hargaMin = parseFloat(filters.hargaMin.value) || 0;
                    let hargaMax = parseFloat(filters.hargaMax.value) || Number.MAX_VALUE;
                    let stokFilter = parseInt(filters.stok.value) || 0;
                    let stokOpsi = filters.stokOpsi.value;
                    let barcodeFilter = filters.barcode.value.toLowerCase();
    
                    let show = 
                        (nama_produk.includes(filters.nama_produk.value.toLowerCase()) || filters.nama_produk.value === "") &&
                        (kategori.includes(filters.kategori.value.toLowerCase()) || filters.kategori.value === "") &&
                        (barcode.includes(barcodeFilter) || barcodeFilter === "") &&
                        (harga_beli >= hargaMin && harga_beli <= hargaMax) &&
                        (harga_jual >= hargaMin && harga_jual <= hargaMax) &&
                        ((stokOpsi === "" || (stokOpsi === "lebih_besar" && stok > stokFilter) || 
                        (stokOpsi === "lebih_kecil" && stok < stokFilter)));
    
                    row.style.display = show ? "" : "none";
                });
            }
    
            Object.values(filters).forEach(input => {
                input.addEventListener("keyup", filterTable);
            });
    
            filters.stokOpsi.addEventListener("change", filterTable);
        });
        </script>
    
</x-app-layout>
