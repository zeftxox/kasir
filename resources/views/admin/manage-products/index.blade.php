<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Manage Produk</h2>

            @if(session('success'))
                <p class="mt-4 text-green-500">{{ session('success') }}</p>
            @endif

            <div class="flex justify-end mt-4">
                <a href="{{ route('admin.manage-products.create') }}" 
                   class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700">
                    + Tambah Produk
                </a>

                <a href="{{ route('admin.manage-products.history') }}" 
                   class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-md shadow-md hover:bg-gray-700">
                    🕒 History Produk
                </a>
            </div>

            <!-- Container Filter -->
            <div class="mt-6 bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow-md">
                <div class="flex flex-wrap items-center gap-3 w-full">
                    <input type="text" id="filterNama" data-filter="nama_produk"
                        class="pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded-md w-1/6 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800"
                        placeholder="🔎 Nama Produk">

                    <input type="text" id="filterKategori" data-filter="kategori"
                        class="pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded-md w-1/6 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800"
                        placeholder="📁 Kategori">

                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 w-1/6">
                        <span class="px-2 text-gray-500 dark:text-gray-400">💰</span>
                        <input type="number" id="filterHargaMin" data-filter="min_price" class="p-2 w-1/2 border-r text-gray-700 dark:text-gray-300 bg-transparent" placeholder="Min">
                        <input type="number" id="filterHargaMax" data-filter="max_price" class="p-2 w-1/2 text-gray-700 dark:text-gray-300 bg-transparent" placeholder="Max">
                    </div>

                    <div class="relative flex items-center border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 w-1/6">
                        <span class="px-2 text-gray-500 dark:text-gray-400">📦</span>
                        <input type="number" id="filterStok" data-filter="stok" class="p-2 w-3/4 text-gray-700 dark:text-gray-300 bg-transparent" placeholder="Stok">
                        <select id="filterStokOpsi" data-filter="stok_op" class="w-1/4 p-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md">
                            <option value="lebih_besar">🔼</option>
                            <option value="lebih_kecil">🔽</option>
                        </select>
                    </div>

                    <input type="text" id="filterBarcode" data-filter="barcode"
                        class="pl-8 p-2 border border-gray-300 dark:border-gray-600 rounded-md w-1/6 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800"
                        placeholder="📌 Barcode">
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
                        @foreach($products as $product)
                            <tr class="product-row">
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 nama_produk">{{ $product->nama_produk }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 kategori">{{ $product->category->kategori }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 harga_beli">Rp {{ number_format($product->harga_beli, 2) }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 harga_jual">Rp {{ number_format($product->harga_jual, 2) }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 stok">{{ $product->stok }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-gray-100 barcode">{{ $product->barcode }}</td>
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
        <!-- Container Pagination -->
        <div class="mt-4 flex justify-between items-center">
            
        <!-- Dropdown "Tampilkan" -->
        <div class="mt-4 flex justify-between items-center">
            <!-- Dropdown "Tampilkan" -->
            <div class="flex items-center space-x-2">
                <label for="perPage" class="text-gray-700 dark:text-gray-300">Tampilkan</label>
                <div class="relative">
                    <select id="perPage" 
                        class="p-2 pr-6 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 appearance-none focus:ring focus:ring-indigo-500">
                        <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>
            </div>
        
            <!-- Paginator -->
            <div class="mt-4 flex justify-end">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
        

    <!-- JavaScript untuk Filter -->
    <script>

    document.getElementById('perPage').addEventListener('change', function () {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.set('page', 1); // Reset ke halaman pertama
        window.location.href = url.toString();
    });

    document.addEventListener("DOMContentLoaded", function () {
        let filters = document.querySelectorAll("[data-filter]");
        let perPageDropdown = document.getElementById("perPage");

        // Fungsi untuk menerapkan filter
        function applyFilter() {
            let url = new URL(window.location.href);

            // Reset ke halaman pertama saat filter diterapkan
            url.searchParams.set('page', 1);

            // Ambil nilai filter dan tambahkan ke URL
            filters.forEach(input => {
                if (input.value !== "") {
                    url.searchParams.set(input.dataset.filter, input.value);
                } else {
                    url.searchParams.delete(input.dataset.filter);
                }
            });

            // Terapkan limit paginasi yang dipilih
            if (perPageDropdown) {
                url.searchParams.set('per_page', perPageDropdown.value);
            }

            window.history.pushState({}, "", url.toString());

            // Fetch data baru dari server dengan Ajax
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    document.querySelector("tbody").innerHTML = doc.querySelector("tbody").innerHTML;
                    document.querySelector(".mt-4.flex.justify-end").innerHTML = doc.querySelector(".mt-4.flex.justify-end").innerHTML;
                });
        }

        // Event listener untuk setiap filter (keyup & change)
        filters.forEach(input => {
            input.addEventListener("keyup", applyFilter);
            input.addEventListener("change", applyFilter);
        });

        // Event listener untuk dropdown paginasi
        if (perPageDropdown) {
            perPageDropdown.addEventListener("change", applyFilter);
        }
    });
</script>
</x-app-layout>
