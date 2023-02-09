<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components\SectionIncidencias;

use App\Models\IncidenciaTripulacion;
use App\Models\Vuelo;
use Livewire\Component;

class SectionIncidenciaTripulacion extends Component
{
    public Vuelo $vuelo;
    public $is_active = false;
    public $form = ['descripcion'];
    public $listeners = [
        'refreshSectionIncidenciaTripulacion' => '$refresh'
    ];
    public function render()
    {
        return view('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-tripulacion');
    }
    public function setTripulacionState($val){
        $this->is_active = $val;
    }
    public function deleteIncidenteTripulacion(IncidenciaTripulacion $incidente){
        $incidente->tripulacion_vuelo_after->delete();
        $incidente->tripulacion_vuelo_before->restore();
        $incidente->delete();

        $this->emit('notify', 'success', 'Se registró correctamente.');
        $this->emitSelf('refreshSectionIncidenciaTripulacion');
        $this->emit('inicidenciaTripulacionDeleted');
    }
}
