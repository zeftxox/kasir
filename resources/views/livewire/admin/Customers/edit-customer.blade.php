<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold text-center dark:text-white mb-4">Edit Pelanggan</h2>

    @if(session()->has('success'))
        <div class="mb-4 text-green-500">{{ session('success') }}</div>
    @endif

    <form wire:submit.prevent="updateCustomer">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-white">Nama Pelanggan</label>
            @error('nama_pelanggan') <span class="text-red-500">{{ $message }}</span> @enderror
            <input type="text" wire:model="nama_pelanggan" 
                class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-white">Alamat</label>
            @error('alamat_pelanggan') <span class="text-red-500">{{ $message }}</span> @enderror
            <input type="text" wire:model="alamat_pelanggan" 
                class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 dark:text-white">Nomor HP</label>
            @error('nomor_hp') <span class="text-red-500">{{ $message }}</span> @enderror
            <input type="text" wire:model="nomor_hp" inputmode="numeric" pattern="[0-9]*"
                class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>

        <div class="flex justify-between">
            <button type="button" onclick="window.history.back()" 
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                🔙 Kembali
            </button>

            <button type="submit" 
                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700">
                ✅ Simpan Perubahan
            </button>
        </div>
    </form>
</div>
