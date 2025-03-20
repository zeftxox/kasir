<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Symfony\Component\HttpFoundation\StreamedResponse;




class TransactionHistory extends Component
{
    use WithPagination;

    public $searchPelanggan = '';
    public $searchTanggal = '';
    public $searchTotalBayar = '';
    public $perPage = 5;
    public $showDeleted = false; // Menampilkan transaksi yang dihapus atau tidak
    public $tanggalMulai, $tanggalAkhir; // Range tanggal untuk filter


    protected $listeners = [
        'deleteTransaction' => 'deleteTransaction', // Event untuk menghapus transaksi
        'restoreTransaction' => 'restoreTransaction' // Event untuk memulihkan transaksi
    ];

    protected $updatesQueryString = [
        'searchPelanggan' => ['except' => ''],
        'searchTanggal' => ['except' => ''],
        'searchTotalBayar' => ['except' => ''],
        'perPage' => ['except' => 10],
        'showDeleted' => ['except' => false],

    ];

    public function updating($field)
    {
        $this->resetPage(); // Reset ke halaman pertama saat filter berubah
    }
    
    public function deleteTransaction($id)
    {
        $transaksi = Penjualan::find($id);

        if ($transaksi) {
            $transaksi->update(['isDeleted' => true]);
            session()->flash('success', 'Transaksi berhasil dihapus.');
        } else {
            session()->flash('error', 'Transaksi tidak ditemukan.');
        }
        $this->dispatch('refreshTable');

    }

    public function restoreTransaction($id)
    {
        $transaksi = Penjualan::find($id);

        if ($transaksi) {
            $transaksi->update(['isDeleted' => false]); // Kembalikan transaksi
            session()->flash('success', 'Transaksi berhasil dikembalikan.');
        } else {
            session()->flash('error', 'Transaksi tidak ditemukan.');
        }
        $this->dispatch('refreshTable');

    }


    public function toggleHistory()
    {
        $this->showDeleted = !$this->showDeleted;
    }
    public function exportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Header
        $headers = ['ID Transaksi', 'Nama Pelanggan', 'Nama Kasir', 'Tanggal Penjualan', 'Total Bayar', 'Status'];
        $columnLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
    
        foreach ($columnLetters as $index => $letter) {
            $sheet->setCellValue($letter . '1', $headers[$index]);
            $sheet->getStyle($letter . '1')->getFont()->setBold(true);
            $sheet->getStyle($letter . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
    
        // Ambil data transaksi
        $query = Penjualan::with(['customer', 'user'])
            ->where('isDeleted', false);
    
        if (Auth::user()->user_level === 'officer') {
            $query->where('id_user', Auth::user()->id);
        }
    
        if (!empty($this->tanggalMulai) && !empty($this->tanggalAkhir)) {
            $query->whereBetween('tanggal_penjualan', [
                Carbon::parse($this->tanggalMulai)->startOfDay(),
                Carbon::parse($this->tanggalAkhir)->endOfDay()
            ]);
        }
    
        $transaksi = $query->get();
    
        // Mengisi data ke dalam sheet
        $row = 2; // Mulai dari baris ke-2 setelah header
        $totalBayar = 0;
    
        foreach ($transaksi as $item) {
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->customer->nama_pelanggan ?? 'Guest');
            $sheet->setCellValue('C' . $row, $item->user->nama ?? 'Tidak ada');
            $sheet->setCellValue('D' . $row, Carbon::parse($item->tanggal_penjualan)->format('d-m-Y'));
            $sheet->setCellValue('E' . $row, $item->total_bayar);
            $sheet->setCellValue('F' . $row, $item->isDeleted ? 'Deleted' : 'Active');
    
            $totalBayar += $item->total_bayar;
            $row++;
        }
    
        // Menambahkan Summary Total Bayar
        $sheet->setCellValue('D' . $row, 'Total Keseluruhan');
        $sheet->getStyle('D' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('E' . $row, $totalBayar);
        $sheet->getStyle('E' . $row)->getFont()->setBold(true);
    
        // Menambahkan border ke semua sel yang memiliki data
        $lastRow = $row; // Baris terakhir yang berisi data
        $borderRange = 'A1:F' . $lastRow;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle($borderRange)->applyFromArray($styleArray);
    
        // Menyimpan dan mengunduh file Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan_transaksi.xlsx';
    
        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
        
    public function printReportPDF()
    {
        // Ambil data transaksi berdasarkan filter range tanggal & isDeleted = false
        $query = Penjualan::with(['customer', 'user'])
            ->where('isDeleted', false);

        if (Auth::user()->user_level === 'officer') {
            $query->where('id_user', Auth::user()->id);
        }

        if (!empty($this->tanggalMulai) && !empty($this->tanggalAkhir)) {
            $query->whereBetween('tanggal_penjualan', [
                Carbon::parse($this->tanggalMulai)->startOfDay(),
                Carbon::parse($this->tanggalAkhir)->endOfDay()
            ]);
        }

        $transaksi = $query->get();

        // Generate PDF
        $pdf = FacadePdf::loadView('livewire.transaction-report', compact('transaksi'))
            ->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan_transaksi.pdf'
        );
    }




    public function render()
    {
        $query = Penjualan::with('customer')
        ->where('isDeleted', $this->showDeleted);

        if (!empty($this->searchPelanggan)) {
            $query->whereHas('customer', function ($q) {
                $q->where('nama_pelanggan', 'like', '%' . $this->searchPelanggan . '%');
            });
        }
        // Cek apakah user adalah officer
        if (Auth::user()->user_level === 'officer') {
            $query->where('id_user', Auth::user()->id);
        }

        if (!empty($this->searchTanggal)) {
            $query->whereDate('tanggal_penjualan', Carbon::parse($this->searchTanggal)->toDateString());
        }

        if (!empty($this->searchTotalBayar)) {
            $query->where('total_bayar', '>=', $this->searchTotalBayar);
        }

        $penjualan = $query->paginate($this->perPage);

        return view('livewire.transaction-history', compact('penjualan'));
    }
}
    