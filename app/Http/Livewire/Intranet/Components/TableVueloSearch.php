<?php

namespace App\Http\Livewire\Intranet\Components;

use App\Models\TipoVuelo;
use App\Models\Ubicacion;
use Livewire\Component;

class TableVueloSearch extends Component
{
    public $vuelos = [];
    public Ubicacion $origen;
    public Ubicacion $destino;
    public $tipo_vuelos;

    public $listeners = [
        'origenSelected',
        'destinoSelected',
    ];

    public function mount(){
        $this->tipo_vuelos = TipoVuelo::get();
    }

    public function render(){
        return view('livewire.intranet.components.table-vuelo-search');
    }

    public function origenSelected(Ubicacion $ubicacion, $_){
        $this->origen = $ubicacion;
    }
    public function destinoSelected(Ubicacion $ubicacion, $_){
        $this->destino = $ubicacion;
    }
    public function removeOrigen(){
        $this->origen = null;
    }
    public function removeDestino(){
        $this->destino = null;
    }

    // public function searchVuelos(){
    //     $this->vuelos =
    // }

}
