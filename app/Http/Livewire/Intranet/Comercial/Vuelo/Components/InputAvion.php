<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components;

use App\Models\Avion;
use Livewire\Component;

class InputAvion extends Component
{
    public $search_avion = '';
    public $emitEvent = 'avionSelected';
    public $minAsientos = null;

    public function mount($minAsientos = null){
        $this->minAsientos = $minAsientos;
    }

    public function render()
    {
        $aviones = [];

        $aviones = Avion::when(strlen($this->search_avion) > 1, function($q){
            $search = '%'.$this->search_avion .'%';
            $q->searchFilter($search);
        })->limit(5)->get();
        return view('livewire.intranet.comercial.vuelo.components.input-avion', compact('aviones'));
    }
    public function selectAvion($id){
        $this->emit($this->emitEvent, $id);
    }
}
