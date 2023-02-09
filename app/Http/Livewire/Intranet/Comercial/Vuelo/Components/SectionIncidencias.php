<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components;

use App\Models\Avion;
use App\Models\IncidenciaAvion;
use App\Models\IncidenciaTripulacion;
use App\Models\Vuelo;
use Livewire\Component;

class SectionIncidencias extends Component
{
    public $tab = 'avion';

    public Vuelo $vuelo;

    public $listeners = [
        'refreshSectionIncidencia' => '$refresh'
    ];
    public function render()
    {
        return view('livewire.intranet.comercial.vuelo.components.section-incidencias');
    }
}
