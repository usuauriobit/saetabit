<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasajero;

use App\Models\Persona;
use Livewire\Component;

class Index extends Component
{
    public function mount(){
    }
    public function render()
    {
        $personas = Persona::has('pasajes')->get();

        return view('livewire.intranet.comercial.pasajero.index', compact('personas'));
    }
}
