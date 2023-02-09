<?php

namespace App\Http\Livewire\Intranet\Configuracion\PasajeCambioTarifa;

use App\Models\PasajeCambioTarifa;
use Livewire\Component;

class Edit extends Component
{
    public PasajeCambioTarifa $pasaje_cambio_tarifa;

    public $form = [
        'monto_cambio_fecha' => 0,
        'monto_cambio_abierto' => 0,
        'monto_cambio_titularidad' => 0,
        'monto_cambio_ruta' => 0,
    ];

    public function mount(){
        $this->form = $this->pasaje_cambio_tarifa->toArray();
    }

    public function render(){
        return view('livewire.intranet.configuracion.pasaje-cambio-tarifa.edit');
    }

    public function save(){
        $this->pasaje_cambio_tarifa->update($this->form);
        return redirect()->route('intranet.configuracion.pasaje_cambio_tarifa.index')->with('success', 'Se registró correctamente');
    }
}
