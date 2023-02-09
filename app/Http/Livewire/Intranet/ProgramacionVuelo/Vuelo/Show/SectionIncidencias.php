<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\Show;

use App\Models\Vuelo;
use App\Models\VueloRuta;
use Livewire\Component;

class SectionIncidencias extends Component
{
    public Vuelo|VueloRuta $vuelo;
    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo.show.section-incidencias');
    }
}
