<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\Show;

use App\Models\Pasaje;
use App\Models\Vuelo;
use Livewire\Component;

class SectionPasajeros extends Component
{
    public Vuelo $vuelo;

    public $listeners = [
        'bultoAdded' => 'refresh',
        'anularPasajeConfirmated' => 'anularPasaje',
        'pasajeChanged' => 'refreshPasajeros',
        // 'pasajeBultoAnulado' => 'refreshPasajeros',
        'pasajeChanged' => 'refreshPasajeros',
    ];

    public function render(){
        return view('livewire.intranet.programacion-vuelo.vuelo.show.section-pasajeros');
    }

    public function refresh(){
        $this->emit('notify', 'success', 'Registrado correctamente');
        $this->emit('closeModals');
        $this->vuelo->refresh();
    }

    public function refreshPasajeros(){
        $this->emit('refreshVuelo');
    }
    public function anularPasaje(Pasaje $pasaje, $observacion){
        if($pasaje->can_anular){
            $pasaje->update(['observacion_anulado' => $observacion]);
            if($pasaje->venta_detalle){
                $venta = $pasaje->venta_detalle->venta;
                $venta->delete();
            }
            $pasaje->delete();
            $this->emit('refreshVuelo');
        }
        $this->emit('notify','success', 'Se anuló correctamente 😃.');
    }
}
