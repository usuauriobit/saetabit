<?php

namespace App\Http\Livewire\Intranet\Comercial\Descuento;

use Carbon\Carbon;
use Livewire\Component;

class ResumenMensual extends Component {
    public $fecha_inicio;
    public $fecha_final;
    public function mount(){
        $this->fecha_inicio = Carbon::now()->firstOfMonth()->format('Y-m-d');
        $this->fecha_final = Carbon::now()->endOfMonth()->format('Y-m-d');
    }
    public function render() {
        return view('livewire.intranet.comercial.descuento.resumen-mensual');
    }
}
