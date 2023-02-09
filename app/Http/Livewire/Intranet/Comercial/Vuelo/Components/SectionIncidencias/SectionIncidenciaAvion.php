<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components\SectionIncidencias;

use App\Models\Avion;
use App\Models\IncidenciaAvion;
use App\Models\Vuelo;
use Livewire\Component;

class SectionIncidenciaAvion extends Component
{
    public Vuelo $vuelo;
    public $avion = null;
    public $is_active = null;
    public $listeners = [
        'avionIncidenteSelected' => 'setAvion',
    ];
    public $form = ['descripcion'];
    public function render()
    {
        return view('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-avion');
    }
    public function setAvionState($val){
        $this->is_active = $val;
    }
    public function setAvion(Avion $avion){
        $this->avion = $avion;
    }
    public function removeAvion(){
        $this->avion = null;
    }
    public function saveAvion(){
        $this->validate([
            'form.descripcion' => 'required',
        ]);
        $this->vuelo->incidencias_avion()->create([
            'avion_before_id' => $this->vuelo->avion_id,
            'avion_after_id' => $this->avion->id,
            'descripcion' => $this->form['descripcion']
        ]);
        $this->vuelo->update([
            'avion_id' => $this->avion->id
        ]);
        $this->emit('notify', 'success', 'Se registró correctamente.');
        $this->emit('inicidenciaSetted');
        $this->emit('refreshSectionIncidencia');
    }
    public function deleteIncidenteAvion(IncidenciaAvion $incidente){
        $this->vuelo->update([
            'avion_id' => $incidente->avion_before_id
        ]);
        $incidente->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente.');
        $this->emit('inicidenciaDeleted');
        $this->emit('refreshSectionIncidencia');
    }
}
