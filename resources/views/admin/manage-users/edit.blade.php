<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Edit User</h2>

            @if(session('error'))
                <p class="mt-4 text-red-500">{{ session('error') }}</p>
            @endif

            @if ($errors->any())
                <ul class="text-red-500">
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('admin.manage-users.update', $user->id) }}" class="mt-6 space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- User Level -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">User Level</label>
                    <select name="user_level"
                            class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                        <option value="admin" {{ $user->user_level === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="officer" {{ $user->user_level === 'officer' ? 'selected' : '' }}>Officer</option>
                    </select>
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Password (Opsional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password (Kosongkan jika tidak ingin diubah)</label>
                    <input type="password" name="password"
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}"
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- No Handphone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">No Handphone</label>
                    <input type="text" name="no_handphone" value="{{ old('no_handphone', $user->no_handphone) }}"
                           class="w-full p-2 mt-1 border rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.manage-users.index') }}" 
                       class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md shadow-md hover:bg-gray-600">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
