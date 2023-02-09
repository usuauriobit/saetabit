<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\VueloRuta;

use App\Models\Vuelo;
use App\Models\VueloRuta;
use Livewire\Component;

class Show extends Component
{
    public VueloRuta $vuelo_ruta;
    public $vuelo_selected;
    // public $tab_incidencia = '';
    // // public $tab = 'pasajeros';
    // public function mount(){
    //     $this->tab_incidencia = 'incidencia_'.$this->vuelo_ruta->vuelos[0]->codigo;
    // }

    public $listeners = [
        'inicidenciaSetted' => '$refresh',
        'inicidenciaTripulacionSetted' => 'refreshVuelo',
        'inicidenciaTripulacionDeleted' => 'refreshVuelo',
        'inicidenciaDeleted' => '$refresh',
        'refreshVuelo' => '$refresh',

    ];

    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo-ruta.show');
    }
    public function setVueloSelected(Vuelo $vuelo){
        $this->vuelo_selected = $vuelo;
    }
    public function emptyVueloSelected(){
        $this->vuelo_selected = null;
    }
}
