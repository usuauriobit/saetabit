<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasaje\Show;

use App\Models\Pasaje;
use Livewire\Component;

class SectionCambioTitularidad extends Component
{
    public Pasaje $pasaje;
    public $pasaje_id;

    public $listeners = [
        'pasajeCambioSetted' => 'refresh',
    ];

    public function mount($pasaje_id){
        $this->pasaje_id = $pasaje_id;
        $this->_getPasaje();
    }

    private function _getPasaje(){
        $this->pasaje = Pasaje::with(['cambios_titularidad', 'cambios_titularidad.pasajero_anterior', 'cambios_titularidad.pasajero_nuevo'])->find($this->pasaje_id);
    }

    public function render()
    {
        return view('livewire.intranet.comercial.pasaje.show.section-cambio-titularidad');
    }

    public function refresh(){
        $this->_getPasaje();
    }
}
