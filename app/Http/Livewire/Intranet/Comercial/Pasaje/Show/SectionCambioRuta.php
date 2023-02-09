<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasaje\Show;

use App\Models\Pasaje;
use Livewire\Component;

class SectionCambioRuta extends Component
{
    public Pasaje $pasaje;
    public $pasaje_id;
    public $listeners = [
        'pasajeCambioSetted' => 'refreshComponent',
    ];

    public function mount($pasaje_id){
        $this->pasaje_id = $pasaje_id;
        $this->_getPasaje();
    }
    private function _getPasaje(){
        $this->pasaje = Pasaje::with([

            'cambios_ruta',
            'cambios_ruta.pasaje_cambio_vuelos_anteriores',
            'cambios_ruta.pasaje_cambio_vuelos_posteriores',
            'cambios_ruta.pasaje_cambio_vuelos_anteriores.vuelo',
            'cambios_ruta.pasaje_cambio_vuelos_posteriores.vuelo'
        ])->find($this->pasaje_id);
    }
    public function render()
    {
        return view('livewire.intranet.comercial.pasaje.show.section-cambio-ruta');
    }

    public function refreshComponent(){
        $this->_getPasaje();
    }
}
