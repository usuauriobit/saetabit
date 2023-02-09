<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo;

use App\Models\CategoriaVuelo;
use App\Models\Ubicacion;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vuelo;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    // public $current_date;
    public $listeners = [
        'daySelected' => 'setDay',
        'origenSetted' => 'setOrigen',
        'destinoSetted' => 'setDestino'
    ];
    public $from = null;
    public $to = null;
    // public $fecha = null;
    public $desde = null;
    public $hasta = null;
    public $origen = null;
    public $destino = null;
    public $categoriaId = null;
    public $filterOptions = [];

    public function mount(){
        $this->filterOptions = CategoriaVuelo::get();
        // $this->current_date = date('Y-m-d');

        // $this->from = date('Y-m-d');
        // $this->to = date('Y-m-d');
        // $this->fecha = date('Y-m-d');
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
    }
    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo.index', [
            'items' => $this->getItems(),
        ]);
    }

    public function getItems() {
        return Vuelo::orderBy('fecha_hora_vuelo_programado', 'desc')
        ->filterSearch(
            search      : $this->search,
            categoria_id: $this->categoriaId,
            desde       : $this->desde,
            hasta       : $this->hasta,
            // fecha       : $this->fecha,
            // from        : $this->from,
            // to          : $this->to,
            origen      :  $this->origen,
            destino     : $this->destino
        )
        ->paginate($this->nro_pagination);
    }
    // public function setDay($date){
    //     $this->current_date = $date;
    // }
    // public function getFechaProperty(){
    //     return Carbon::parse($this->current_date)->formatLocalized('%d %B %Y');
    // }
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

