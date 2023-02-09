<?php

namespace App\Http\Livewire\Intranet\Comercial\VueloCredito;

use App\Models\VueloCredito;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component{
    use WithPagination;
    public $nro_pagination = 10;
    public function render(){
        return view('livewire.intranet.comercial.vuelo-credito.index', [
            'items' => $this->getItems(),
        ]);
    }
    public function getItems() {
        return VueloCredito::with(['vuelo_ruta', 'vuelo_ruta.tipo_vuelo'])->paginate($this->nro_pagination);
    }
}
