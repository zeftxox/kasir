<div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold text-center dark:text-white mb-4">Transaksi Baru</h2>

        @if(session('error'))
            <p class="mt-4 text-red-500">{{ session('error') }}</p>
        @endif
        @if(session('success'))
            <p class="mt-4 text-green-500">{{ session('success') }}</p>
        @endif

        <!-- Switch Button untuk Menggunakan Data Pelanggan -->
        <div class="flex items-center mb-4">
            <label class="mr-2 dark:text-white">Gunakan Pelanggan?</label>
            <input type="checkbox" wire:model.live="useCustomer" class="toggle-checkbox rounded-sm">
        </div>

        @if($useCustomer)
            <!-- Pencarian Pelanggan -->
            <div class="mb-3">
                <label class="block text-sm font-medium text-white">Cari Pelanggan</label>
                <input type="text" wire:model.live="searchCustomer"
                    class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Cari Nama atau Nomor HP">
                @if(!empty($filteredCustomers))
                    <div class="bg-white dark:bg-gray-700 rounded-md shadow-md mt-2">
                        @foreach($filteredCustomers as $customer)
                            <p class="p-2 cursor-pointer hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800" 
                                wire:click="selectCustomer({{ $customer->id }})">
                                {{ $customer->nama_pelanggan }} - {{ $customer->nomor_hp }}
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Tombol Tambah Pelanggan -->
            <button wire:click="toggleCustomerForm"
                class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">
                + Tambah Pelanggan
            </button>

            <!-- Form Tambah Pelanggan -->
            @if($showCustomerForm)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-md mt-4 shadow-md">
                    <h3 class="text-lg font-semibold text-center dark:text-white">Tambah Pelanggan</h3>

                    <input type="text" wire:model="nama_customer" 
                        class="w-full p-2 border rounded-md mt-2 dark:bg-gray-700 dark:text-white" placeholder="Nama Pelanggan">
                    
                    <input type="text" wire:model="alamat_customer" 
                        class="w-full p-2 border rounded-md mt-2 dark:bg-gray-700 dark:text-white" placeholder="Alamat">
                    
                    <input type="text" wire:model="nomor_customer" 
                        class="w-full p-2 border rounded-md mt-2 dark:bg-gray-700 dark:text-white" placeholder="Nomor HP">
                    
                    <button wire:click="saveCustomer" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        Simpan
                    </button>
                    <button wire:click="toggleCustomerForm" class="mt-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Batal
                    </button>
                </div>
            @endif
        @endif


        <!-- Input Barcode -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-white">Scan Barcode</label>
            <input id="barcodeInput" type="text" wire:model.live="barcode"
            class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
            placeholder="Scan atau Ketik Barcode..."
            autocomplete="off">        
        </div>
        

        <!-- Tabel Produk yang Dipilih -->
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="p-2 text-left">Nama Produk</th>
                        <th class="p-2 text-center">Qty</th>
                        <th class="p-2 text-left">Harga</th>
                        <th class="p-2 text-left">Subtotal</th>
                        <th class="p-2 text-left">Diskon</th>
                        <th class="p-2 text-left">Harga diskon</th>
                        <th class="p-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 dark:text-white">
                    @foreach($cart as $index => $item)
                        <tr class="border-t">
                            <td class="p-2 dark:text-white">{{ $item['nama_produk'] }}</td>
                            <td class="p-2 text-center flex items-center justify-center space-x-2">
                                <button wire:click="decreaseQty({{ $index }})" class="px-2 py-1 rounded-md hover:text-gray-700 hover:bg-gray-200">−</button>
                                <span class="font-semibold">{{ $item['qty'] }}</span>
                                <button wire:click="increaseQty({{ $index }})" class="px-2 py-1 rounded-md hover:text-gray-700 hover:bg-gray-200">+</button>
                            </td>
                            <td class="p-2">Rp {{ number_format($item['harga_jual']) }}</td>
                            <td class="p-2">Rp {{ number_format($item['subtotal']) }}</td>
                            <td class="p-2">
                                <input type="number" min="0" max="100" 
                                    id="discount-{{ $index }}"
                                    wire:model.live="cart.{{ $index }}.discount"
                                    wire:change.live="updateProductDiscount({{ $index }}, $event.target.value)"
                                    class="w-16 p-1 border rounded-md text-center dark:bg-gray-700 dark:text-white"
                                    oninput="validateDiscount(this)">
                            </td>
                            
                            <td class="p-2 ">Rp {{ number_format($item['harga_discount']) }}</td>
                                                        
                            <td class="p-2 text-center">
                                <button wire:click="removeFromCart({{ $index }})"
                                    class="px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Perhitungan Total -->
        <div class="mt-4">
            <div class="flex justify-between dark:text-white">
                <span class="text-lg font-semibold">Total Harga:</span>
                <span class="text-lg">Rp {{ number_format($total_harga) }}</span>
            </div>

            <div class="flex justify-between mt-2 ">
                <span class="text-lg font-semibold dark:text-white">Diskon (%):</span>
                <input type="number" min="0" max="100" wire:model.live="discount"
                    class="w-16 p-1 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="flex justify-between mt-2">
                <span class="text-lg font-semibold dark:text-white">Total Bayar:</span>
                <span class="text-lg font-bold text-green-600">Rp {{ number_format($total_bayar) }}</span>
            </div>

            <div class="flex justify-between mt-2 ">
                <span class="text-lg font-semibold dark:text-white">Nominal Bayar:</span>
                <input type="number" min="0" wire:model.live="uang_bayar"
                    class="w-24 p-1 border rounded-md focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>

            <div class="flex justify-between mt-2 dark:text-white">
                <span class="text-lg font-semibold">Kembalian:</span>
                <span class="text-lg font-bold text-blue-600"
                        id="kembalianValue"
                >Rp {{ number_format(max($kembalian, 0)) }}</span>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <button wire:click="saveTransaction"
            class="w-full mt-4 p-2 bg-green-500 text-white rounded-md hover:bg-green-600">
            Simpan Transaksi
        </button>
        <!-- Modal Popup Transaksi Berhasil -->
        @if($showSuccessPopup)
        <div class="fixed inset-0 flex items-center justify-center  bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-lg font-semibold text-green-500 text-center">Pembayaran Berhasil!</h2>
                <div class="mt-4 flex justify-center space-x-2">
                    <button wire:click="showNota()"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        🖨️ Print Nota
                    </button>
                    <button wire:click="resetTransaction"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        ✅ Selesai
                    </button>
                </div>
            </div>
        </div>
        @endif

        @if($showNotaPopup && $lastTransaction)
        <div id="notaPopupContainer" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 sm:max-h-[80vh] overflow-y-auto">
                <div id="notaPopup">
                    <div class="nota-header text-center">
                        <h2 class="text-lg font-semibold text-gray-800">Nota Transaksi</h2>
                        <p>No. Transaksi: <strong>{{ $lastTransaction->id }}</strong></p>
                        <p>Tanggal: <strong>{{ date('d-m-Y', strtotime($lastTransaction->tanggal_penjualan)) }}</strong></p>
                        <p>Pelanggan: <strong>{{ $lastTransaction->customer->nama_pelanggan ?? 'Umum' }}</strong></p>
                        <p>Petugas: <strong>{{ $lastTransaction->user->nama }}</strong></p>
                    </div>
        
                    <hr class="my-2 border-dashed border-gray-400">
        
                    <!-- Daftar Produk -->
                    <h3 class="text-md font-semibold text-gray-800 mb-2 text-center">Detail Pembelian</h3>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b border-gray-400 text-gray-700">
                                <th class="p-1 text-left">Produk</th>
                                <th class="p-1 text-center">Qty</th>
                                <th class="p-1 text-right">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lastTransaction->detailPenjualan as $item)
                            <tr class="border-t border-dashed border-gray-300">
                                <td class="p-1">
                                    {{ $item->product->nama_produk }}<br>
                                    @if($item->discount > 0)
                                        <span class="text-xs text-gray-500">Diskon: {{ $item->discount }}% | 
                                        Disc: <span class="text-blue-600">Rp {{ number_format($item->subtotal - $item->harga_discount, 0, ',', '.') }}</span></span>
                                    @endif
                                </td>
                                <td class="p-1 text-center">{{ $item->qty }}</td>
                                <td class="p-1 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
        
                    <hr class="my-2 border-dashed border-gray-400">
        
                    <!-- Total Pembayaran -->
                    <div class="nota-footer text-sm">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($lastTransaction->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Diskon Transaksi:</span>
                            <span>{{ $lastTransaction->discount }}%</span>
                        </div>
                        <div class="flex justify-between font-bold text-green-600">
                            <span>Total Bayar:</span>
                            <span>Rp {{ number_format($lastTransaction->total_bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Nominal Bayar:</span>
                            <span>Rp {{ number_format($lastTransaction->nominal_bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-blue-600 font-bold">
                            <span>Kembalian:</span>
                            <span>Rp {{ number_format($lastTransaction->kembalian, 0, ',', '.') }}</span>
                        </div>
                    </div>
        
                    <hr class="my-2 border-dashed border-gray-400">
        
                </div>
                <!-- Tombol Aksi -->
                <div class="mt-4 flex justify-center space-x-2">
                    <button onclick="printNota()" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        🖨️ Print Nota
                    </button>
                    <button wire:click="resetTransaction"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        ✅ Selesai
                    </button>
                </div>
            </div>
        </div>
        @endif
    

    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let barcode = '';
    let inputTimeout;

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            if (barcode.length > 0) {
                Livewire.emit('barcodeScanned', barcode); // Kirim barcode ke Livewire
                barcode = ''; // Reset barcode
            }
            event.preventDefault();
        } else if (/^[a-zA-Z0-9]$/.test(event.key)) { // Hanya karakter valid
            barcode += event.key;
            clearTimeout(inputTimeout);
            inputTimeout = setTimeout(() => barcode = '', 500); // Reset jika tidak ada input dalam 500ms
        }
    });

    // Event listener untuk mereset barcode setelah produk ditambahkan
    Livewire.on('productAdded', function () {
        const barcodeInput = document.getElementById('barcodeInput');
        if(barcodeInput) barcodeInput.value = ''; // Reset input barcode
        barcodeInput.focus(); // Kembalikan fokus
        barcode = ''; // Reset variabel barcode juga untuk keamanan
    });
});
document.addEventListener("DOMContentLoaded", function () {
    Livewire.on("resetTransaction", function () {
        // Tunggu 1 detik sebelum reload agar pengguna melihat notifikasi sukses
        setTimeout(function () {
            window.location.reload();
        }, 1000);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    Livewire.on("updateKembalian", function (kembalian) {
        const kembalianElement = document.getElementById("kembalianValue");
        if (kembalianElement) {
            kembalianElement.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(kembalian);
        }
    });
});



function printNota() {
        var printContents = document.getElementById("notaPopup").innerHTML;

        var printWindow = window.open("", "_blank", "width=400,height=600");
        printWindow.document.write(`
            <html>
            <head>
                <title>Nota Transaksi</title>
                <style>
                    * { font-family: 'Courier New', Courier, monospace; font-size: 12px; }
                    body { width: 300px; height: auto; margin: 0 auto; color: #000; text-align: center; }
                    h2 { font-size: 14px; margin: 5px 0; font-weight: bold; }
                    .nota-header, .nota-footer { text-align: center; }
                    .nota-header p, .nota-footer p { margin: 2px 0; font-size: 12px; }
                    
                    /* Tabel Produk */
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    th, td { border-bottom: 1px dashed #000; padding: 5px 0; }
                    th { font-weight: bold; text-align: center; }
                    td.qty { 
                        text-align: center; /* Pusatkan teks Qty */
                    }
                    td.subtotal { 
                        text-align: right; /* Subtotal rata kanan */
                    }
                    td:first-child { text-align: left; }


                    /* Garis Pemisah */
                    .separator { border-top: 1px dashed black; margin: 5px 0; }

                    /* Footer Nota */
                    .nota-footer { margin-top: 10px; font-size: 12px; }
                    .nota-footer div { display: flex; justify-content: space-between; padding: 3px 0; }
                    .nota-footer .total { font-size: 14px; font-weight: bold; }
                    
                    @media print {
                        body { width: 300px; height: auto; font-size: 12px; }
                        h2 { font-size: 14px; }
                        .nota-header p, .nota-footer p { font-size: 12px; }
                    }
                </style>
            </head>
            <body onload="window.print();">
                ${printContents}
            </body>
            </html>
        `);
//  window.close(); // Jika ingin menutup jendela print setelah selesai
        printWindow.document.close();
    }
    document.addEventListener('DOMContentLoaded', function () {
    // Event dari Livewire untuk memperbarui input jika lebih dari 100
    Livewire.on('updateDiscountInput', function (data) {
        let inputElement = document.getElementById('discount-' + data.index);
        if (inputElement) {
            inputElement.value = data.value; // Paksa update nilai input ke 100 jika lebih
        }
    });
});

// Validasi langsung saat pengguna mengetik
function validateDiscount(input) {
    if (input.value > 100) {
        input.value = 100; // Paksa nilai ke 100
    }
    if (input.value < 0 || input.value === '') {
        input.value = 0; // Jika kosong atau negatif, atur ke 0
    }
}
</script>
