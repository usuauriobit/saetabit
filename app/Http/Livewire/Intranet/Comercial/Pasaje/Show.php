<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasaje;

use App\Models\PasajeCambio;
use App\Models\Pasaje;
use App\Models\PasajeLiberacionHistorial;
use App\Models\Venta;
use Illuminate\Http\Request;
use PDF;
use Livewire\Component;

class Show extends Component
{
    public Pasaje $pasaje;
    public $tab = 'cambio_titularidad';

    public $listeners = [
        'pasajeCambioSetted' => '$refresh',
        'anularPasajeConfirmated' => 'anularPasaje',
        'pasajeChanged' => 'refreshPasaje'
    ];


    public function mount($pasaje_id){
        $this->pasaje = Pasaje::with(['pasajero', 'pasajero.tipo_documento', 'tipo_pasaje', 'vuelos', 'tipo_pasaje'])->find($pasaje_id);
        if($this->pasaje->is_charter || !$this->can_registrar_cambios_pasaje){
            $this->setTab('comprobantes');
        }
    }

    public function render(){
        return view('livewire.intranet.comercial.pasaje.show');
    }

    public function setTab($tab){
        $this->tab = $tab;
    }

    public function eliminarCambio(PasajeCambio $cambio){
        $cambio->pasaje->update([
            'pasajero_id' => $cambio->pasajero_anterior_id
        ]);
        $cambio->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente.');
        $this->pasaje->refresh();
    }

    public function anularPasaje(Pasaje $pasaje){
        if($pasaje->can_anular){
            $pasaje->delete();
        }
        $this->emit('notify','success', 'Se anuló correctamente 😃.');
        return redirect()->route('intranet.comercial.adquisicion-pasaje.index');
    }

    public function refreshPasaje(){
        $this->pasaje->refresh();
    }
    public function getCanRegistrarCambiosPasajeProperty(){
        return ($this->pasaje->is_comercial || $this->pasaje->is_subvencionado || $this->pasaje->is_no_regular) && $this->pasaje->is_pagado;
    }
}
