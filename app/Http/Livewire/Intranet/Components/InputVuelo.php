<?php

namespace App\Http\Livewire\Intranet\Components;

use App\Models\Vuelo;
use Livewire\Component;

class InputVuelo extends Component
{
    public $search_vuelo = '';
    public $vuelo_founded = null;
    public function render()
    {
        return view('livewire.intranet.components.input-vuelo');
    }
    public function searchVuelo(){
        $vuelo = Vuelo::whereCodigo($this->search_vuelo)->first();
        if(!$vuelo){
            $this->emit('notify','error', 'No se encontró ningún vuelo');
            return;
        }
        $this->vuelo_founded = $vuelo;
    }

    public function setVuelo($type = ''){
        if($type == 'with_next'){
            $emitData = [$this->vuelo_founded->id, $this->vuelo_founded->vuelo_siguiente->id];
        }else{
            $emitData = [$this->vuelo_founded->id];
        }

        $this->emit('vuelosSelected', $emitData);
    }
}
