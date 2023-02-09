<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\Show;

use App\Models\Tripulacion;
use App\Models\TripulacionVuelo;
use App\Models\Vuelo;
use Livewire\Component;

class SectionTripulacion extends Component
{
    public Vuelo $vuelo;
    public $listeners = [
        'tripulacionSelected' => 'setTripulacion'
    ];
    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo.show.section-tripulacion');
    }
    public function setTripulacion(Tripulacion $tripulacion){
        $this->vuelo->tripulacion_vuelo()->create([
            'tripulacion_id' => $tripulacion->id
        ]);
        $this->vuelo->refresh();
        $this->emit('tripulacionSetted');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
    public function deleteTripulacionVuelo(TripulacionVuelo $tripulacion_vuelo){
        $tripulacion_vuelo->delete();
        $this->vuelo->refresh();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
}
