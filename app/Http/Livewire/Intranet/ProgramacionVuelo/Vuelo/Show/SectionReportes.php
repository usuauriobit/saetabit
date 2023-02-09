<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\Show;

use Livewire\Component;

use App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\ShowTraits\ExportTrait;
use App\Models\Vuelo;

class SectionReportes extends Component
{
    use ExportTrait;
    public Vuelo $vuelo;
    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo.show.section-reportes',[
            'preliminares' => [
                [
                    'desc' => 'Lista preliminar de pasajeros',
                    'route' => route('intranet.programacion-vuelo.vuelo.export.preliminar-pasajeros.pdf', ['vuelo' => $this->vuelo])
                ],
                [
                    'desc' => 'Lista preliminar de cargas',
                    'route' => route('intranet.programacion-vuelo.vuelo.export.preliminar-cargas.pdf', ['vuelo' => $this->vuelo])
                ],
            ],
            'manifiestos' => [
                [
                    'desc' => 'Manifiesto de pasajeros',
                    'route' => route('intranet.programacion-vuelo.vuelo.export.manifiesto-pasajeros.pdf', ['vuelo' => $this->vuelo])
                ],
                [
                    'desc' => 'Manifiesto de cargas',
                    'route' => route('intranet.programacion-vuelo.vuelo.export.manifiesto-cargas.pdf', ['vuelo' => $this->vuelo])
                ],
            ]
        ]);
    }
}
