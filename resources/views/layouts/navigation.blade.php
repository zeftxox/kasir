<nav x-data="{ open: false, darkMode: localStorage.getItem('darkMode') === 'true' }" 
     x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
     :class="{ 'dark': darkMode }"
     class="bg-white dark:bg-gray-800 border-b shadow-md border-gray-100 dark:border-gray-700">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->user_level === 'admin')
                        <x-nav-link :href="route('admin.manage-users.index')" :active="request()->routeIs('admin.manage-users.index')">
                            {{ __('Manage Users') }}
                        </x-nav-link>  

                        <!-- Dropdown Manage Produk & Kategori -->

                        @php
                            $activeManageProducts = request()->routeIs('admin.manage-products.index') || request()->routeIs('admin.manage-category.index');
                        @endphp
                        <div class="flex items-end">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <x-nav-link class="inline-flex  py-5 text-sm leading-5 font-medium 
                                        transition duration-150 ease-in-out
                                        {{ $activeManageProducts ? 'inline-flex items-center border-b-2 text-gray-300 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 dark:text-white focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out' }}">
                                        <span>Manage Produk</span>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </x-nav-link>
                                </x-slot>
    
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('admin.manage-products.index')" :active="request()->routeIs('admin.manage-products.index')">
                                        {{ __('Daftar Produk') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.manage-category.index')" :active="request()->routeIs('admin.manage-category.index')">
                                        {{ __('Kategori Produk') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>                       
                         </div>

                        <x-nav-link :href="route('admin.penjualan.index')" :active="request()->routeIs('admin.penjualan.index','admin.penjualan.show')">
                            {{ __('Manage Penjualan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.index')">
                            {{ __('Manage Customers') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.penjualan.create')" :active="request()->routeIs('admin.penjualan.create')">
                            {{ __('Create Transaction') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->user_level === 'officer')
                        <x-nav-link :href="route('admin.penjualan.create')">
                            {{ __('Create Transaction') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.penjualan.index')">
                            {{ __('Transaction History') }}
                        </x-nav-link>
                        <x-nav-link :href="route('officer.manage-products')" :active="request()->routeIs('officer.manage-products')">
                            {{ __('Manage Products') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->nama }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        <!-- Dark Mode Toggle -->
                        <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                            <button @click="darkMode = !darkMode; document.documentElement.classList.toggle('dark', darkMode)" 
                                class="group w-full flex items-center space-x-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-gray-200 dark:hover:text-gray-700 hover:text-gray-200 rounded-md">
                                <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 3a1 1 0 100 2 1 1 0 000-2zM3.05 7.05a1 1 0 101.414 1.414A1 1 0 003.05 7.05zM2 10a1 1 0 102 0 1 1 0 00-2 0zm1.05 4.95a1 1 0 101.414-1.414 1 1 0 00-1.414 1.414zM10 15a1 1 0 100 2 1 1 0 000-2zm6.95-.05a1 1 0 101.414-1.414 1 1 0 00-1.414 1.414zM18 10a1 1 0 10-2 0 1 1 0 002 0zm-1.05-4.95a1 1 0 10-1.414 1.414 1 1 0 001.414-1.414zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 group-hover:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M17.293 14.293a8 8 0 01-11.586-11.586A8 8 0 0117.293 14.293zm-5.293.707a7 7 0 100-14 7 7 0 000 14z" clip-rule="evenodd"/>
                                </svg>
                                <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                            </button>
                        </div>
                         
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
