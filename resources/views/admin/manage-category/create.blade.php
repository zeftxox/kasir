<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Tambah Kategori</h2>

            @if(session('error'))
                <p class="mt-4 text-red-500">{{ session('error') }}</p>
            @endif

            @if ($errors->any())
            @foreach ($errors->all() as $item)
                <li>{{ $item }}</li>
            @endforeach
             @endif

            <form method="POST" action="{{ route('admin.manage-category.store') }}" class="mt-6 space-y-4">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                    <input type="text" name="kategori"
                    class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end my-3">
                    <button type="submit"
                            class="px-4 py-2 bg-white text-gray-700 font-semibold rounded-md shadow-md hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

