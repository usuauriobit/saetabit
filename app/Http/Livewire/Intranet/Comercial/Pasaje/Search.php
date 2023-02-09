<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasaje;

use App\Models\Pasaje;
use Livewire\Component;

class Search extends Component
{
    public $codigo_pasaje = '';
    public function searchPasaje(){
        $pasaje = Pasaje::whereCodigo($this->codigo_pasaje)->first();
        if(!$pasaje){
            $this->emit('notify', 'error', 'No se ningún pasaje con el código ingresado');
            return;
        }

        return redirect()->route('intranet.comercial.pasaje.show', $pasaje->id);
    }
    public function render()
    {
        return view('livewire.intranet.comercial.pasaje.search');
    }
}
