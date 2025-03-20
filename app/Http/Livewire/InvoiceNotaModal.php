<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

class InvoiceNotaModal extends Component
{
    public $penjualan;
    public $showInvoice = false;
    public $showNota = false;

    protected $listeners = ['openInvoiceModal' => 'showInvoiceModal', 'openNotaModal' => 'showNotaModal'];

    public function showInvoiceModal($id)
    {
        $this->penjualan = Penjualan::with('detailPenjualan.product', 'customer', 'user')->findOrFail($id);
        $this->showInvoice = true;
        $this->showNota = false;
    }

    public function showNotaModal($id)
    {
        $this->penjualan = Penjualan::with('detailPenjualan.product', 'customer', 'user')->findOrFail($id);
        $this->showNota = true;
        $this->showInvoice = false;
    }

    public function render()
    {
        return view('livewire.invoice-nota-modal');
    }
}
