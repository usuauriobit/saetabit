<?php

namespace App\Http\Livewire\Intranet\Configuracion\PasajeCambioTarifa;

use App\Models\PasajeCambioTarifa;
use Livewire\Component;

class Index extends Component
{
    public function render() {
        return view('livewire.intranet.configuracion.pasaje-cambio-tarifa.index', [
            'pasaje_cambio_tarifas' => PasajeCambioTarifa::get()
        ]);
    }
}
