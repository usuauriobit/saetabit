<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\Avion;

use App\Models\Avion;
use App\Models\TiempoAvionTramo;
use Livewire\Component;

class Show extends Component {
    public Avion $avion;
    public function render() {
        return view('livewire.intranet.mantenimiento.avion.show');
    }
    public function delete(TiempoAvionTramo $tiempoAvionTramo){
        $tiempoAvionTramo->delete();
        $this->emit('alert', 'success', 'Tiempo de vuelo eliminado correctamente');
    }
}
