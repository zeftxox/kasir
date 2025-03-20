<div>
    <!-- Modal Background -->
    <div x-data="{ open: @entangle('showInvoice') || @entangle('showNota') }" x-show="open" 
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        
        <!-- Modal Box -->
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl relative">
            <!-- Close Button -->
            <button @click="open = false" class="absolute top-2 right-2 bg-gray-300 p-1 rounded-full">
                ✖
            </button>

            <!-- Invoice View -->
            <div x-show="@entangle('showInvoice')">
                <h2 class="text-xl font-bold text-center mb-2">INVOICE</h2>
                <div class="text-sm text-gray-700">
                    <strong>PT IndoKasir</strong><br>
                    Alamat: Indokasir Demo Office, Jugo, Kesamben, Blitar, Jawa Timur <br>
                    Tanggal: {{ $penjualan->tanggal_penjualan }} <br>
                    Kasir: {{ $penjualan->user->name }}
                </div>

                <table class="w-full mt-3 border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2">No</th>
                            <th class="p-2">Deskripsi</th>
                            <th class="p-2">Qty</th>
                            <th class="p-2">Harga</th>
                            <th class="p-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan->detailPenjualan as $index => $item)
                            <tr>
                                <td class="p-2">{{ $index+1 }}</td>
                                <td class="p-2">{{ $item->product->nama_produk }}</td>
                                <td class="p-2">{{ $item->qty }}</td>
                                <td class="p-2">Rp {{ number_format($item->harga_jual, 2) }}</td>
                                <td class="p-2">Rp {{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 text-right">
                    <p><strong>Subtotal:</strong> Rp {{ number_format($penjualan->total_harga, 2) }}</p>
                    <p><strong>Diskon:</strong> Rp {{ number_format($penjualan->discount, 2) }}</p>
                    <p><strong>Total Bayar:</strong> Rp {{ number_format($penjualan->total_bayar, 2) }}</p>
                </div>

                <button onclick="printInvoice()" class="w-full bg-blue-500 text-white p-2 mt-4 rounded">
                    Print Invoice 🖨️
                </button>
            </div>

            <!-- Nota View -->
            <div x-show="@entangle('showNota')">
                <h2 class="text-xl font-bold text-center mb-2">NOTA</h2>
                <div class="text-sm text-gray-700 text-center">
                    <strong>IndoKasir</strong><br>
                    Kasir: {{ $penjualan->user->name }}<br>
                    Tanggal: {{ $penjualan->tanggal_penjualan }}
                </div>

                <table class="w-full mt-3 border">
                    @foreach($penjualan->detailPenjualan as $item)
                        <tr>
                            <td class="p-2">{{ $item->product->nama_produk }} ({{ $item->qty }}x)</td>
                            <td class="p-2 text-right">Rp {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </table>

                <div class="mt-4 text-right">
                    <p><strong>Total:</strong> Rp {{ number_format($penjualan->total_harga, 2) }}</p>
                    <p><strong>Dibayar:</strong> Rp {{ number_format($penjualan->total_bayar, 2) }}</p>
                    <p><strong>Kembalian:</strong> Rp {{ number_format($penjualan->kembalian, 2) }}</p>
                </div>

                <button onclick="printNota()" class="w-full bg-green-500 text-white p-2 mt-4 rounded">
                    Print Nota 🖨️
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Print -->
    <script>
        function printInvoice() {
            let printContents = document.querySelector('[x-show="showInvoice"]').innerHTML;
            let originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function printNota() {
            let printContents = document.querySelector('[x-show="showNota"]').innerHTML;
            let originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</div>
