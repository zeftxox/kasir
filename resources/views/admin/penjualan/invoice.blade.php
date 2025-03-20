<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $penjualan->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
        .btn-print { margin-top: 20px; padding: 10px 20px; background: blue; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

    <h2>Invoice #{{ $penjualan->id }}</h2>
    <p>Tanggal: {{ $penjualan->tanggal_penjualan }}</p>
    <p>Pelanggan: {{ $penjualan->customer->nama_pelanggan ?? 'Guest' }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->detailPenjualan as $item)
            <tr>
                <td>{{ $item->product->nama_produk }}</td>
                <td>Rp {{ number_format($item->harga_jual) }}</td>
                <td>{{ $item->qty }}</td>
                <td>Rp {{ number_format($item->subtotal) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total Harga</td>
                <td class="total">Rp {{ number_format($penjualan->total_harga) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Total Bayar</td>
                <td class="total">Rp {{ number_format($penjualan->total_bayar) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Kembalian</td>
                <td class="total">Rp {{ number_format($penjualan->kembalian) }}</td>
            </tr>
        </tfoot>
    </table>

    <button class="btn-print" onclick="window.print()">🖨️ Cetak Nota</button>

</body>
</html>
