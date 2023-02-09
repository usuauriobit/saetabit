<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\CreateMassive;

use App\Models\Ruta;
use App\Models\Tarifa;
use App\Models\TipoPasaje;
use Livewire\Component;

class TarifasDisponiblesListener extends Component {
    public Ruta $ruta;
    public $result = [];
    public function render() {

        $tipo_pasajes = TipoPasaje::get();
        foreach ($tipo_pasajes as $tipo_pasaje) {
            $tarifa = Tarifa::where('ruta_id', $this->ruta->id ?? null)
                ->where('tipo_pasaje_id', $tipo_pasaje->id)
                ->first();
            if($tarifa){
                $result[] = [
                    'tipo_pasaje' => $tipo_pasaje->descripcion
                ];
            }
        }
        return view('livewire.intranet.programacion-vuelo.vuelo.create-massive.tarifas-disponibles-listener');
    }
}
