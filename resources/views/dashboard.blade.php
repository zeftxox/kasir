<x-app-layout>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="text-center mb-6">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                        <h3 >Selamat Datang, {{ Auth::user()->nama }}</h3>
                        <p>Anda login sebagai <strong>{{ ucfirst(Auth::user()->user_level) }}</strong></p>
                    </div>
                    @if (Auth::user()->user_level === 'admin')
                        <div class="mt-6">
                            {{-- <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 text-center">Dashboard Admin</h2> --}}
                            <livewire:admin.dashboard-stats />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
