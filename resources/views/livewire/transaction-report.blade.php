<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; font-size: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">Laporan Riwayat Transaksi</div>
    <p>Periode: <strong>{{ \Carbon\Carbon::parse(request()->input('tanggalMulai'))->format('d M Y') }}</strong> 
        - <strong>{{ \Carbon\Carbon::parse(request()->input('tanggalAkhir'))->format('d M Y') }}</strong>
     </p>
         
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Nama Petugas</th>
                <th>Pelanggan</th>
                <th>Total Bayar</th>
                <th>Tanggal Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>INV/{{ $item->id }}/{{ \Carbon\Carbon::parse($item->tanggal_penjualan)->year }}</td>
                <td>{{ $item->user->nama }}</td>
                <td>{{ $item->customer->nama_pelanggan ?? 'Guest' }}</td>
                <td>Rp {{ number_format($item->total_bayar, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
