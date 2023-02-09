<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Subvencionado;

use App\Models\TipoVuelo;
use App\Models\Vuelo;
use App\Models\VueloMassive;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public $nro_pagination = 10;
    public function render()
    {
        $search = '%'.$this->search .'%';
        return view('livewire.intranet.comercial.vuelo.subvencionado.index', [
            'items' => VueloMassive::latest()
            ->whereTipoVueloId(TipoVuelo::whereDescripcion('Subvencionado')->first()->id)
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q->searchFilter($q, $search);
            })
            ->paginate($this->nro_pagination),
        ]);
    }
}
