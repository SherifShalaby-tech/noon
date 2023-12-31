<?php

namespace App\Http\Livewire\CustomerPriceOffer;

use App\Models\Invoice;
use App\Models\System;
use Livewire\Component;

class Show extends Component
{
    public $invoice,$qrCode,$setting;

    public function mount($id){
        $this->invoice = Invoice::with(['items','user','customer'])->findOrFail($id);
        $this->setting = System::pluck('value', 'key');
    }
    public function render()
    {
        return view('livewire.invoices.show');
    }
}
