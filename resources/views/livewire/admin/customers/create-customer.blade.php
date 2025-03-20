<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 text-center">Tambah Pelanggan</h2>

        @if(session('success'))
            <p class="mt-4 text-green-500 text-center">{{ session('success') }}</p>
        @endif

        <form wire:submit.prevent="createCustomer">  <!-- Metode harus cocok dengan Livewire -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan</label>
                @error('nama_pelanggan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                <input type="text" wire:model.live="nama_pelanggan"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500"
                    placeholder="Masukkan Nama Pelanggan">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                @error('alamat_pelanggan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                <input type="text" wire:model.live="alamat_pelanggan"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500"
                    placeholder="Masukkan Alamat Pelanggan">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor HP</label>
                @error('nomor_hp') 
                <p class="text-danger text-red-500 text-sm">{{ $message }}</p> 
                @enderror
                <input type="text" wire:model.live="nomor_hp"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500"
                    placeholder="Masukkan Nomor HP">

                </div>
            <div class="flex justify-between mt-6">
                <a href="{{ route('admin.customers.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    🔙 Kembali
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    ➕ Tambah Pelanggan
                </button>
            </div>
        </form>
    </div>
</div>
