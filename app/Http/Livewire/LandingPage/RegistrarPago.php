<?php

namespace App\Http\Livewire\LandingPage;

use App\Models\OrdenPasaje;
use Livewire\Component;

class RegistrarPago extends Component {
    public string $codigo_orden;
    public OrdenPasaje $orden_pasaje;
    public function mount(){
        $this->orden_pasaje = OrdenPasaje::whereCodigo($this->codigo_orden)->first();
    }
    public function render() {
        return view('livewire.landing-page.registrar-pago');
    }
}
