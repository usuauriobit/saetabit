<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components\SectionIncidencias;

use App\Models\IncidenciaTripulacion;
use App\Models\Tripulacion;
use App\Models\TripulacionVuelo;
use Livewire\Component;

class SectionIncidenciaTripulacionCreate extends Component
{
    public TripulacionVuelo $tripulacionVueloActual;
    public $tripulacion_new;
    public $listeners = [
        'tripulacionIncidenciaSelected' => 'setIncidenteTripulacion',
        // 'refreshSectionIncidenciaTripulacion' => '$refresh'
    ];
    public $form = [
        'descripcion_tripulacion'
    ];
    public function render()
    {
        return view('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-tripulacion-create');
    }
    public function setIncidenteTripulacion(Tripulacion $tripulacion){
        $this->tripulacion_new = $tripulacion;
    }
    public function saveIncidencia(){
        if(!$this->tripulacion_new) {
            $this->emit('notify', 'error', 'Seleccione la tripulación reemplazo');
            return;
        }
        $this->validate([
            'form.descripcion_tripulacion' => 'required'
        ]);

        $nuevo_tripulacion_vuelo = $this->tripulacionVueloActual->vuelo->tripulacion_vuelo()->create([
            'tripulacion_id' => $this->tripulacion_new->id,
        ]);

        $incidencia = $this->tripulacionVueloActual->vuelo->incidencias_tripulacion()->create([
            'tripulacion_vuelo_before_id' => $this->tripulacionVueloActual->id,
            'tripulacion_vuelo_after_id' => $nuevo_tripulacion_vuelo->id,
            'descripcion' => $this->form['descripcion_tripulacion']
        ]);

        $this->tripulacionVueloActual->delete();

        $this->emit('notify', 'success', 'Se registró correctamente.');
        $this->emit('inicidenciaTripulacionSetted');
        // $this->emit('refreshSectionIncidenciaTripulacion');
    }
    public function deleteNewTripulacion(){
        $this->tripulacion_new = null;

        // $this->vuelo->update([
        //     'avion_id' => $incidente->avion_before_id
        // ]);
        // $incidente->delete();
        // $this->emit('notify', 'success', 'Se eliminó correctamente.');
        // $this->emit('inicidenciaDeleted');
        // $this->emit('refreshSectionIncidenciaTripulacion');
    }
}
