<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardStats extends Component
{
    public $totalPendapatan;
    public $totalTransaksi;
    public $totalProdukTerjual;
    public $chartData = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Total Pendapatan
        $this->totalPendapatan = Penjualan::sum('total_bayar');

        // Total Transaksi
        $this->totalTransaksi = Penjualan::count();

        // Total Produk Terjual
        $this->totalProdukTerjual = DetailPenjualan::sum('qty');

        // Data untuk Grafik (Penjualan per hari dalam 7 hari terakhir)
        $this->chartData = Penjualan::select(
                DB::raw('DATE(tanggal_penjualan) as date'),
                DB::raw('COUNT(id) as total_transaksi'),
                DB::raw('SUM(total_bayar) as total_pendapatan')
            )
            ->where('tanggal_penjualan', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-stats');
    }
}
