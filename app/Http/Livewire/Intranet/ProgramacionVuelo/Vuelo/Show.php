<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\GuiaDespachoStep;
use App\Models\TripulacionVuelo;
use App\Models\GuiaDespacho;
use App\Models\Tripulacion;
use App\Models\Avion;
use App\Models\Pasaje;
use App\Models\Vuelo;
use PDF;


class Show extends Component
{
    public Vuelo $vuelo;
    public $tab = 'resumen';
    public $contain = false;
    public $close_form = [];
    public $listeners = [
        'inicidenciaSetted' => '$refresh',
        'inicidenciaTripulacionSetted' => 'refreshVuelo',
        'inicidenciaTripulacionDeleted' => 'refreshVuelo',
        'inicidenciaDeleted' => '$refresh',
        'pasajeSetted' => '$refresh',
        'refreshVuelo' => '$refresh',
    ];

    public function render()
    {
        $this->dispatchBrowserEvent('refreshJS');
        return view('livewire.intranet.programacion-vuelo.vuelo.show');
    }

    public function setTab($tab){
        $this->tab = $tab;
    }
    public function refreshVuelo(){
        $this->vuelo->refresh();
    }

}
