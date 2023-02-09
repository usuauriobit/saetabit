<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasaje\Show;

use App\Models\Pasaje;
use Livewire\Component;

class SectionCambioFecha extends Component {
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
                'cambios_fecha',
                'cambios_fecha.cambio_vuelo_origen_anterior',
                'cambios_fecha.cambio_vuelo_origen_anterior.vuelo',
                'cambios_fecha.cambio_vuelo_origen_posterior',
                'cambios_fecha.cambio_vuelo_origen_posterior.vuelo',
        ])->find($this->pasaje_id);
    }
    public function render() {
        return view('livewire.intranet.comercial.pasaje.show.section-cambio-fecha');
    }

    public function refreshComponent(){
        $this->_getPasaje();
    }

}
