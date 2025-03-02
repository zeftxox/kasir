<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Tambah Produk</h2>

            @if(session('error'))
                <p class="mt-4 text-red-500">{{ session('error') }}</p>
            @endif

            @if ($errors->any())
                <ul class="text-red-500">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('admin.manage-products.store') }}" class="mt-6 space-y-4">
                @csrf

                <!-- Nama Produk -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
                    <input type="text" name="nama_produk" placeholder="Masukkan nama produk" required
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Harga Produk -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Beli</label>
                    <input type="number" name="harga_beli" placeholder="Masukkan harga beli produk" required
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Jual</label>
                    <input type="number" name="harga_jual" placeholder="Masukkan harga jual produk" required
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Stok Produk -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok</label>
                    <input type="number" name="stok" placeholder="Jumlah stok" required
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Barcode -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Barcode</label>
                    <input type="text" name="barcode" placeholder="Masukkan barcode produk (13 digit)" required maxlength="13"
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Kategori Produk -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                    <select name="id_kategori"
                            class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                        <option value="" disabled selected>Pilih kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('admin.manage-products.index') }}" 
                       class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-md hover:bg-gray-600">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
