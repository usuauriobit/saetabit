<?php

namespace App\Http\Livewire\Intranet\Comercial\PasajeAbierto;

use App\Models\Pasaje;
use Livewire\Component;

class Index extends Component
{
    public $nro_pasajes_abiertos_pendientes = 0;
    public $nro_pagination = 10;
    public $nro_documento = '';
    public $search = '';
    public $desde = '';
    public $hasta = '';
    public $origen = '';
    public $destino = '';
    public $state = 'todos';

    public $states = [
        [
            'id' => 'todos',
            'descripcion' => 'Todos',
        ],
        [
            'id' => 'pendiente',
            'descripcion' => 'Pendiente',
        ],
        [
            'id' => 'asignado',
            'descripcion' => 'Asignado',
        ],
        [
            'id' => 'anulado',
            'descripcion' => 'Anulado',
        ]
    ];

    public function mount(){
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
        $this->nro_pasajes_abiertos_pendientes = Pasaje::where('is_abierto', true)->count();
    }
    public function render() {
        return view('livewire.intranet.comercial.pasaje-abierto.index', [
            'items' => Pasaje::whereNotNull('fecha_was_abierto')
                ->when(strlen($this->search) > 3, function ($query) {
                    $query->whereHas('pasajero', function ($query) {
                        $query->whereNombreLike("%{$this->search}%");
                    });
                })
                ->when($this->nro_documento, function ($query) {
                    $query->whereHas('pasajero', function ($query) {
                        $query->where('nro_doc', 'ilike', "%{$this->nro_documento}%");
                    });
                })
                ->when($this->origen, function ($query) {
                    $query->whereHas('origen.ubigeo', function ($query) {
                        return $query->where('distrito', 'ilike', "%{$this->origen}%");
                    });
                })
                ->when($this->destino, function ($query) {
                    $query->whereHas('destino.ubigeo', function ($query) {
                        return $query->where('distrito', 'ilike', "%{$this->destino}%");
                    });
                })
                ->when($this->desde, function ($query) {
                    $query->whereDate('fecha', '>=', $this->desde);
                })
                ->when($this->hasta, function ($query) {
                    $query->whereDate('fecha', '<=', $this->hasta);
                })
                ->when($this->state == 'todos', function ($query) {
                    $query->withTrashed();
                })
                ->when($this->state == 'pendiente', function ($query) {
                    $query->where('is_abierto', true);
                })
                ->when($this->state == 'asignado', function ($query) {
                    $query->where('is_abierto', false);
                })
                ->when($this->state == 'anulado', function ($query) {
                    $query->whereNotNull('deleted_at');
                })
                ->paginate($this->nro_pagination)
        ]);
    }
}
