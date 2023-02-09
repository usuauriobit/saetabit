<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\Show;

use App\Models\Avion;
use App\Models\Vuelo;
use Livewire\Component;

class SectionAvion extends Component
{
    public Vuelo $vuelo;

    public $listeners = [
        'avionSelected' => 'setAvion',
    ];
    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo.show.section-avion');
    }
    public function setAvion(Avion $avion){
        $this->vuelo->update(['avion_id' => $avion->id]);
        $this->vuelo->refresh();
        $this->emit('refreshVuelo');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
    public function deleteAvion(Avion $avion){
        $this->vuelo->update(['avion_id' => null]);
        $this->vuelo->refresh();
        $this->emit('refreshVuelo');
    }
}
