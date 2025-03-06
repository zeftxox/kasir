<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Transaksi Baru</h2>

            <form id="transaksiForm" method="POST" action="{{ route('admin.penjualan.store') }}">
                @csrf

                <!-- Input Nama Customer -->
                <label for="nama_customer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan (Opsional)</label>
                <input type="text" name="nama_customer" id="nama_customer" 
                    class="p-2 border border-gray-300 dark:border-gray-600 rounded-md w-full text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:ring focus:ring-indigo-500"
                    placeholder="Masukkan Nama Pelanggan">
                <!-- Input Nama Alamat -->
                <label for="alamat_cusomer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan (Opsional)</label>
                <input type="text" name="alamat_cusomer" id="alamat_cusomer" 
                    class="p-2 border border-gray-300 dark:border-gray-600 rounded-md w-full text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:ring focus:ring-indigo-500"
                    placeholder="Masukkan Nama Pelanggan">
                <!-- Input Nama Customer -->
                <label for="nomor_customer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan (Opsional)</label>
                <input type="text" name="nomor_customer" id="nomor_customer" 
                    class="p-2 border border-gray-300 dark:border-gray-600 rounded-md w-full text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:ring focus:ring-indigo-500"
                    placeholder="Masukkan Nama Pelanggan">

                <!-- Input Produk -->
                <div class="mt-4">
                    <input type="text" id="searchProduct" class="p-2 border rounded w-full" placeholder="Cari produk (nama/barcode)">
                    <div id="productResults" class="mt-2 bg-white border rounded shadow"></div>
                </div>
                

                <!-- Tabel Produk yang Dipilih -->
                <div class="mt-6 overflow-x-auto">
                    <table class="w-full border rounded-md bg-white dark:bg-gray-900">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                <th class="px-4 py-2">Nama Produk</th>
                                <th class="px-4 py-2">Harga Jual</th>
                                <th class="px-4 py-2">Qty</th>
                                <th class="px-4 py-2">Subtotal</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="transactionTableBody"></tbody>
                    </table>
                </div>

                <label>Diskon (%)</label>
                <input type="number" id="discount" class="p-2 border rounded w-24" value="0" min="0" max="100" oninput="updatePayment()">
                
                <label>Total Harga</label>
                <span id="totalHarga">Rp 0</span>
            
                <label>Total Bayar</label>
                <input type="number" id="totalBayar" class="p-2 border rounded w-24" min="0" oninput="updatePayment()">
            
                <label>Kembalian</label>
                <span id="kembalian">Rp 0</span>
            </div>
            <button onclick="saveTransaction()" class="mt-4 p-2 bg-green-500 text-white rounded">Simpan Transaksi</button>

            </form>
            
        </div>
    </div>

    <script>
        let totalHarga = 0;
        let produkList = [];

        function tambahProduk(id, nama, harga) {
            let qty = 1;
            let subtotal = harga * qty;

            produkList.push({ id, nama, harga, qty, subtotal });
            renderTable();
            hitungTotal();
        }

        function renderTable() {
            let tbody = document.getElementById('produkList');
            tbody.innerHTML = '';

            produkList.forEach((item, index) => {
                tbody.innerHTML += `
                    <tr>
                        <td class="px-4 py-2">${item.nama}</td>
                        <td class="px-4 py-2">Rp ${item.harga}</td>
                        <td class="px-4 py-2"><input type="number" min="1" value="${item.qty}" onchange="updateQty(${index}, this.value)" class="w-16 p-1 border rounded-md"></td>
                        <td class="px-4 py-2">Rp ${item.subtotal}</td>
                        <td class="px-4 py-2"><button onclick="hapusProduk(${index})" class="px-2 py-1 bg-red-500 text-white rounded-md">Hapus</button></td>
                    </tr>
                `;
            });
        }

        function updateQty(index, qty) {
            produkList[index].qty = qty;
            produkList[index].subtotal = produkList[index].harga * qty;
            renderTable();
            hitungTotal();
        }

        function hapusProduk(index) {
            produkList.splice(index, 1);
            renderTable();
            hitungTotal();
        }

        function hitungTotal() {
            totalHarga = produkList.reduce((sum, item) => sum + item.subtotal, 0);
            document.getElementById('total_bayar').value = totalHarga;
        }

        document.getElementById('searchProduct').addEventListener('keyup', function () {
    let query = this.value;
    if (query.length > 2) {
        fetch(`/search-product?query=${query}`)
            .then(response => response.json())
            .then(data => {
                let resultHtml = '';
                data.forEach(product => {
                    resultHtml += `<div class="p-2 hover:bg-gray-200 cursor-pointer" 
                                      onclick="addProductToTransaction(${product.id}, '${product.nama_produk}', ${product.harga_jual})">
                                      ${product.nama_produk} - Rp ${product.harga_jual.toLocaleString()}
                                  </div>`;
                });
                document.getElementById('productResults').innerHTML = resultHtml;
            });
    } else {
        document.getElementById('productResults').innerHTML = '';
    }
});

function addProductToTransaction(id, nama, harga) {
    let tableBody = document.getElementById('transactionTableBody');
    let existingRow = document.getElementById(`product-${id}`);

    if (existingRow) {
        let qtyInput = existingRow.querySelector('.qty-input');
        qtyInput.value = parseInt(qtyInput.value) + 1;
    } else {
        let rowHtml = `
            <tr id="product-${id}">
                <td>${nama}</td>
                <td><input type="number" class="qty-input p-1 border rounded w-16" value="1" min="1" 
                           oninput="updateSubtotal(${id}, ${harga})"></td>
                <td>Rp ${harga.toLocaleString()}</td>
                <td id="subtotal-${id}">Rp ${harga.toLocaleString()}</td>
                <td><button onclick="removeProduct(${id})" class="p-1 bg-red-500 text-white rounded">Hapus</button></td>
            </tr>`;
        tableBody.innerHTML += rowHtml;
    }

    updateTotal();
}

function updateSubtotal(id, harga) {
    let qty = document.querySelector(`#product-${id} .qty-input`).value;
    let subtotal = harga * qty;
    document.getElementById(`subtotal-${id}`).innerText = `Rp ${subtotal.toLocaleString()}`;
    updateTotal();
}

function removeProduct(id) {
    document.getElementById(`product-${id}`).remove();
    updateTotal();
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('#transactionTableBody tr').forEach(row => {
        let subtotal = row.querySelector('.qty-input').value * parseFloat(row.cells[2].innerText.replace(/[^\d.-]/g, ''));
        total += subtotal;
    });

    document.getElementById('totalHarga').innerText = `Rp ${total.toLocaleString()}`;
}

function updatePayment() {
    let totalHarga = parseFloat(document.getElementById('totalHarga').innerText.replace(/[^\d]/g, '')) || 0;
    let discount = parseFloat(document.getElementById('discount').value) || 0;
    let totalBayar = parseFloat(document.getElementById('totalBayar').value) || 0;

    let totalAkhir = totalHarga - (totalHarga * (discount / 100));
    let kembalian = totalBayar - totalAkhir;

    document.getElementById('kembalian').innerText = `Rp ${kembalian.toLocaleString()}`;
}


function saveTransaction() {
    let totalHargaElement = document.getElementById('totalHarga');
    let discountElement = document.getElementById('discount');
    let totalBayarElement = document.getElementById('totalBayar');
    let kembalianElement = document.getElementById('kembalian');
    let namaCustomerElement = document.getElementById('nama_customer');
    let alamatCustomerElement = document.getElementById('alamat_customer');
    let nomorCustomerElement = document.getElementById('nomor_customer');

    // Cek apakah elemen ditemukan
    if (!totalHargaElement || !discountElement || !totalBayarElement || !kembalianElement) {
        alert("Terjadi kesalahan! Beberapa elemen tidak ditemukan.");
        return;
    }

    let total_harga = parseFloat(totalHargaElement.innerText.replace(/[^\d]/g, '')) || 0;
    let discount = parseFloat(discountElement.value) || 0;
    let total_bayar = parseFloat(totalBayarElement.value) || 0;
    let kembalian = parseFloat(kembalianElement.innerText.replace(/[^\d]/g, '')) || 0;
    let nama_customer = namaCustomerElement?.value || null;
    let alamat_customer = alamatCustomerElement?.value || null;
    let nomor_customer = nomorCustomerElement?.value || null;

    let products = [];
    document.querySelectorAll('#transactionTableBody tr').forEach(row => {
        let id = row.id.replace('product-', '');
        let qty = row.querySelector('.qty-input').value;
        let harga = parseFloat(row.cells[2].innerText.replace(/[^\d]/g, ''));
        let subtotal = harga * qty;
        products.push({ id_product: id, qty, harga_jual: harga, subtotal });
    });

    if (products.length === 0) {
        alert('Tambahkan minimal 1 produk!');
        return;
    }

    fetch("{{ route('admin.penjualan.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            nama_customer,
            alamat_customer,
            nomor_customer,
            products,
            total_harga,
            discount,
            total_bayar,
            kembalian
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "{{ route('admin.penjualan.index') }}";
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

    </script>
</x-app-layout>
