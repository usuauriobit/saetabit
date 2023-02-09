<?php

namespace App\Http\Livewire\Intranet\Caja\Comprobante;

use App\Models\Comprobante;
use App\Services\FacturacionService;
use Livewire\Component;

class Show extends Component
{
    public Comprobante $comprobante;

    public function mount()
    {
        // $json = FacturacionService::generarJson($this->comprobante);
    }

    public function render()
    {
        dd(FacturacionService::generarJson($this->comprobante));
        return view('livewire.intranet.caja.comprobante.show');
    }
}
