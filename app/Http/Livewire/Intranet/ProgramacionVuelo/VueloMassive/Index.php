<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\VueloMassive;

use App\Models\CategoriaVuelo;
use App\Models\VueloMassive;
use App\Models\TipoVuelo;
use App\Models\Ubicacion;
use Livewire\Component;
use App\Models\Vuelo;

class Index extends Component
{
    public $search = '';
    public $nro_pagination = 10;
    public $desde = null;
    public $hasta = null;
    public $origen = null;
    public $destino = null;
    public $categoriaId = null;
    public $filterOptions = [];
    public $listeners = [
        'origenSetted' => 'setOrigen',
        'destinoSetted' => 'setDestino'
    ];

    public function mount()
    {
        $this->filterOptions = CategoriaVuelo::get();
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
    }

    public function render()
    {
        $search = '%'.$this->search .'%';
        return view('livewire.intranet.programacion-vuelo.vuelo-massive.index', [
            'items' => VueloMassive::latest()
            ->filterSearch(
                search      : $this->search,
                categoria_id: $this->categoriaId,
                // from        : $this->from,
                // to          : $this->to,
                // fecha       : $this->fecha,
                desde       : $this->desde,
                hasta       : $this->hasta,
                origen      :  $this->origen,
                destino     : $this->destino
            )
            ->paginate($this->nro_pagination),
        ]);


    }

    public function getOrigenModelProperty()
    {
        return Ubicacion::find($this->origen);
    }
    public function getDestinoModelProperty()
    {
        return Ubicacion::find($this->destino);
    }

    public function setOrigen($_, $id)
    {
        $this->origen = $id;
    }
    public function setDestino($_, $id)
    {
        $this->destino = $id;
    }

    public function deleteUbicacion($type)
    {
        if($type == 'origen'){
            $this->origen = null;
        }else{
            $this->destino = null;
        }
    }
}
