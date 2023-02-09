<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components;

use App\Models\Ubicacion;
use Livewire\Component;

class InputUbicacion extends Component
{
    public $type;
    public $nroCols = 3;
    public $search_ubicacion = '';
    public $label = 'Buscar ubicación';
    public $nameEvent = 'ubicacionSelected';
    public $listeners = [
        'cleanUbicacionInput' => 'clear'
    ];
    public $onlyAllowed = false;
    public function mount(){
        // $this->ubicacions = Ubicacion::get();
    }
    public function render()
    {
        $search = '%'.$this->search_ubicacion .'%';
        $ubicacions = [];
        if(strlen($this->search_ubicacion) > 0){
            $ubicacions = Ubicacion::searchFilter($search)->orderBy('codigo_icao', 'desc')->get();
        }else{
            $ubicacions = Ubicacion::whereIsPermited()->orderBy('codigo_icao', 'desc')->get();
        }
        return view('livewire.intranet.comercial.vuelo.components.input-ubicacion', compact('ubicacions'));
    }
    public function selectUbicacion($id){
        $this->emit($this->nameEvent, $this->type, $id);
    }
    public function clear(){
        $this->search_ubicacion = '';
    }
}
