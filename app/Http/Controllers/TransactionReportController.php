<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TransactionReportController extends Controller
{
    public function print(Request $request)
    {
        // Ambil filter tanggal
        $tanggalMulai = $request->input('tanggalMulai');
        $tanggalAkhir = $request->input('tanggalAkhir');

        // Query transaksi dengan filter
        $query = Penjualan::with(['customer', 'user'])
            ->where('isDeleted', false);

        if (!empty($tanggalMulai) && !empty($tanggalAkhir)) {
            $query->whereBetween('tanggal_penjualan', [
                Carbon::parse($tanggalMulai)->startOfDay(),
                Carbon::parse($tanggalAkhir)->endOfDay()
            ]);
        }

        $transaksi = $query->get();

        // Buat PDF
        $pdf = Pdf::loadView('reports.transaction-report', compact('transaksi', 'tanggalMulai', 'tanggalAkhir'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('laporan_transaksi.pdf'); // Menampilkan PDF tanpa mengunduh
    }
}
