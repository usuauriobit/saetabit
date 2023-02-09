<?php

namespace App\Http\Livewire\Intranet\Components;

use App\Models\Ubigeo;
use Livewire\Component;

class InputUbigeo extends Component
{
    public $eventName = "ubigeoSetted";
    public $label = "Buscar ubigeo";
    public $search = "";
    public function render()
    {
        $search = '%'.$this->search .'%';
        $ubicacions = [];

        $ubigeos = [];
        if(strlen($search) > 4)
            $ubigeos = Ubigeo::filterSearch($search)->get();

        return view('livewire.intranet.components.input-ubigeo', compact('ubigeos'));
    }
    public function selectUbigeo($id){
        $this->emit($this->eventName, $id);
        $this->search = '';
    }
}
