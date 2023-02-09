<?php

namespace App\Http\Livewire\Intranet\Caja\Devolucion;

use App\Models\Cliente;
use App\Models\Devolucion;
use App\Models\Persona;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $nro_doc_devolucion = '';
    public $nro_doc_dv = '';
    public $cliente_devolucion = '';
    public $cliente_dv = '';
    public $status = '';
    public $status_devolucion = [];
    public $desde = null;
    public $hasta = null;
    public $desde_dv = null;
    public $hasta_dv = null;
    public $nro_pagination = 10;

    public function mount()
    {
        $this->oficina = Auth::user()->personal->oficina;
        $this->status_devolucion = $this->arrayStatus();
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
        $this->desde_dv = date('Y-m-d');
        $this->hasta_dv = date('Y-m-d');
    }

    public function render()
    {
        $nro_doc_devolucion = '%'.$this->nro_doc_devolucion .'%';
        $cliente_devolucion = '%'.$this->cliente_devolucion .'%';
        $nro_doc_dv = '%'.$this->nro_doc_dv .'%';
        $cliente_dv = '%'.$this->cliente_dv .'%';

        return view('livewire.intranet.caja.devolucion.index', [
            'items' => Devolucion::withTrashed()
                    ->latest()
                    ->whereOficinaId($this->oficina->id)
                    ->when(strlen($this->nro_doc_devolucion) > 2, function($query) use ($nro_doc_devolucion) {
                        $query->whereHas('placelable.venta', function ($query) use ($nro_doc_devolucion) {
                            $query->whereHasMorph('clientable',
                                [Cliente::class, Persona::class],
                                function ($query, $type) use ($nro_doc_devolucion) {
                                    $column = $type === Cliente::class ? 'ruc' : 'nro_doc';
                                    $query->where($column, 'like', $nro_doc_devolucion);
                                });
                        });
                    })
                    ->when(strlen($this->cliente_devolucion) > 2, function($query) use ($cliente_devolucion) {
                        $query->whereHas('placelable.venta', function ($query) use ($cliente_devolucion) {
                            $query->whereHasMorph('clientable',
                                [Cliente::class, Persona::class],
                                function ($query, $type) use ($cliente_devolucion) {
                                    if ($type === Cliente::class)
                                        $query->where('razon_social', 'like', $cliente_devolucion);
                                    else
                                        $query->whereNombreLike($cliente_devolucion);
                            });
                        });
                    })
                    ->when($this->desde, function ($query) {
                        $query->whereDate('fecha', '>=', $this->desde);
                    })
                    ->when($this->hasta, function ($query) {
                        $query->whereDate('fecha', '<=', $this->hasta);
                    })
                    ->when($this->status, function ($query) {
                        $query->whereStatusReviewed($this->status);
                    })
                    ->paginate(10),
            'detalles_ventas' => VentaDetalle::whereDoesntHave('devolucion', function ($query) {
                                        $query->whereNotIn('status_reviewed', ['Rechazado']);
                                    })
                                    ->whereHas('venta', function ($query) {
                                        $query->whereOficinaId($this->oficina->id)
                                            ->whereHas('caja_movimiento.apertura_cierre', function ($query) {
                                                $query->whereNotNull('fecha_cierre');
                                            });
                                    })
                                    ->when($this->nro_doc_dv, function ($query) use ($nro_doc_dv) {
                                        $query->whereHas('venta', function ($query) use ($nro_doc_dv) {
                                            $query->whereHasMorph('clientable',
                                            [Cliente::class, Persona::class],
                                            function ($query, $type) use ($nro_doc_dv) {
                                                $column = $type === Cliente::class ? 'ruc' : 'nro_doc';
                                                $query->where($column, 'like', $nro_doc_dv);
                                            });
                                        });
                                    })
                                    ->when($this->cliente_dv, function ($query) use ($cliente_dv) {
                                        $query->whereHas('venta', function ($query) use ($cliente_dv) {
                                            $query->whereHasMorph('clientable',
                                                [Cliente::class, Persona::class],
                                                function ($query, $type) use ($cliente_dv) {
                                                    if ($type === Cliente::class)
                                                        $query->where('razon_social', 'like', $cliente_dv);
                                                    else
                                                        $query->whereNombreLike($cliente_dv);
                                            });
                                        });
                                    })
                                    ->when($this->desde_dv, function ($query) {
                                        $query->whereHas('venta', function ($query) {
                                            $query->whereDate('created_at', '>=', $this->desde_dv);
                                        });
                                    })
                                    ->when($this->hasta_dv, function ($query) {
                                        $query->whereHas('venta', function ($query) {
                                            $query->whereDate('created_at', '<=', $this->hasta_dv);
                                        });
                                    })
                                    ->has('venta.comprobante')
                                    ->paginate(10),
        ]);
    }

    public function arrayStatus()
    {
        return [
            [ 'id' => 'Aprobado', 'descripcion' => 'Aprobado' ],
            [ 'id' => 'Rechazado', 'descripcion' => 'Rechazado' ],
            [ 'id' => 'En Revisión', 'descripcion' => 'En Revisión' ],
        ];
    }

    public function addVentaDetalle($id)
    {
        return redirect()->route('intranet.caja.devolucion.create', ['venta_detalle_id' => $id ]);
    }
}
