<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\VueloRuta;

use App\Models\CategoriaVuelo;
use App\Models\Ubicacion;
use App\Models\VueloRuta;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $nro_pagination = 10;

    // public $from = null;
    // public $to = null;
    // public $fecha = null;
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

    public function mount(){
        $this->filterOptions = CategoriaVuelo::get();
        // $this->fecha = date('Y-m-d');
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
    }
    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo-ruta.index', [
            'items' => $this->getItems()
        ]);
    }
    public function getItems() {
        return VueloRuta::orderBy('created_at', 'desc')
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
            ->paginate($this->nro_pagination);
    }

    public function getOrigenModelProperty(){
        return Ubicacion::find($this->origen);
    }
    public function getDestinoModelProperty(){
        return Ubicacion::find($this->destino);
    }

    public function setOrigen($_, $id){
        $this->origen = $id;
    }
    public function setDestino($_, $id){
        $this->destino = $id;
    }

    public function deleteUbicacion($type){
        if($type == 'origen'){
            $this->origen = null;
        }else{
            $this->destino = null;
        }
    }
}
