<?php

namespace App\Http\Livewire\Intranet\TrackingCarga\GuiaDespacho;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GuiaDespacho;
use App\Models\Oficina;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $from = null;
    public $to = null;
    public $nro_documento = '';
    public $ubigeoOrigenSelected = null;
    public $ubigeoOrigenOptions = [];
    public $ubigeoDestinoSelected = null;
    public $ubigeoDestinoOptions = [];

    public $oficina_selected_id = null;
    public $oficinas = null;

    public $estadoSelected = 'todos';

    public $estadoOptions = [
        [
            'id' => 'todos',
            'descripcion' => 'Todos'
        ],
        [
            'id' => 'pendiente',
            'descripcion' => 'Pendiente'
        ],
        [
            'id' => 'entregado',
            'descripcion' => 'Entregado'
        ],
    ];

    public function mount(Request $resquest){
        $this->oficina_selected_id = Oficina::find($resquest->oficina_id ?? null)->id ?? null;
        $this->oficinas = Auth::user()->oficinas;

        $ubigeos = Ubigeo::has('ubicaciones')->get();
        $this->ubigeoOrigenOptions = $ubigeos;
        $this->ubigeoDestinoOptions = $ubigeos;
        $this->from = date('Y-m-d');
        $this->to = date('Y-m-d');

    }
    public function render(){
        return view('livewire.intranet.tracking-carga.guia-despacho.index', [
            'items' => $this->getItems()
        ]);
    }
    public function getItems() {
        return GuiaDespacho::orderBy('fecha', 'desc')
        ->filter(
            search: $this->search,
            ubigeoOrigenId: $this->ubigeoOrigenSelected,
            ubigeoDestinoId: $this->ubigeoDestinoSelected,
            from: $this->from,
            to: $this->to,
            nro_documento: $this->nro_documento,
            estado: $this->estadoSelected,
        )
        ->withTrashed()
        ->paginate($this->nro_pagination);
    }

    public function getOficinaSelectedProperty(){
        return Oficina::find($this->oficina_selected_id);
    }

}
