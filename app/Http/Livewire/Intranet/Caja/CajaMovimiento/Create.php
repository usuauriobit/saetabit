<?php

namespace App\Http\Livewire\Intranet\Caja\CajaMovimiento;

use App\Models\Caja;
use Livewire\Component;

class Create extends Component
{
    public Caja $caja;
    public $tab = 'ingreso';
    public $type = 'venta';

    public function render()
    {
        return view('livewire.intranet.caja.caja-movimiento.create');
    }
    public function setTab($tab){
        $this->tab = $tab;
    }
    public function setType($type){
        $this->type = $type;
    }
}
