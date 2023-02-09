<?php

namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Components;

use App\Models\Vuelo;
use Livewire\Component;

class ItemVueloSelect extends Component
{
    public array $vuelos = [];
    public $isAlreadySelected = false;
    public $emitEvent = 'vueloSelected';
    public $paramEmitEvent = null;
    public $canSelect = true;

    public $hideAsientosDisponibles = false;
    public $hideCodigo = false;

    public function mount(){

        foreach ($this->vuelos_model as $vuelo_db) {
            if(!$vuelo_db->has_asientos_disponibles)
                $this->canSelect = false;
        }
    }

    public function render()
    {
        return view('livewire.intranet.comercial.adquisicion-pasaje.components.item-vuelo-select');
    }
    public function selectVuelo(){
        $this->emit($this->emitEvent, $this->paramEmitEvent);
        $this->isAlreadySelected = true;
    }
    public function getVuelosModelProperty(){
        $vuelos_id = array_map(fn($v) => $v['id'], $this->vuelos);
        return Vuelo::find($vuelos_id);
    }
}
