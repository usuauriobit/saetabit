<?php

namespace App\Http\Livewire\Intranet\Caja\CajaMovimiento\Components;

use App\Models\Venta;
use Livewire\Component;

class SectionVenta extends Component
{
    public function render()
    {
        return view('livewire.intranet.caja.caja-movimiento.components.section-venta', [
            'items' => Venta::doesntHave('caja_movimiento')->paginate(10)
        ]);
    }
}
