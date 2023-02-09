<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasajero;

use App\Models\Persona;
use Livewire\Component;

class Show extends Component
{
    public Persona $persona;
    public function render()
    {
        return view('livewire.intranet.comercial.pasajero.show');
    }
}
