<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo;

use App\Models\Vuelo;
use Livewire\Component;

class Search extends Component
{
    public $codigo_vuelo = '';
    public function searchVuelo(){
        $vuelo = Vuelo::whereCodigo($this->codigo_vuelo)->first();
        if(!$vuelo){
            $this->emit('notify', 'error', 'No se encontró ningún vuelo con el código ingresado');
            return;
        }

        return redirect()->route('intranet.programacion-vuelo.vuelo.show', $vuelo);
    }
    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo.search');
    }
}
