<?php

namespace App\Http\Livewire\Intranet\Comercial\PasajeCambio;

use App\Models\PasajeCambio;
use App\Models\PasajeVuelo;
use App\Models\TipoDocumento;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component{
    use WithPagination;

    public $search = '';
    public $desde = '';
    public $hasta = '';
    public $nro_pagination = 10;
    public $tipo_documento_id = null;
    public $nro_documento = '';

    public $estado_options = [
        [
            'id' => 'Todos',
            'descripcion' => 'Todos'
        ],
        [
            'id' => 'Pendiente',
            'descripcion' => 'Pendiente'
        ],
        [
            'id' => 'Confirmado',
            'descripcion' => 'Confirmado'
        ],
        [
            'id' => 'Eliminado',
            'descripcion' => 'Eliminado'
        ],
    ];
    public $filter_estado = 'Todos';

    public function mount()
    {
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
        $this->tipo_documentos = TipoDocumento::get();
    }

    public function render()
    {
        return view('livewire.intranet.comercial.pasaje-cambio.index',[
            'items' => $this->getItems(),
            'nro_pendientes' => PasajeCambio::where('is_confirmado', false)->count(),
        ]);
    }
    public function getItems() {
        $search = '%'.$this->search .'%';

        return PasajeCambio::latest()
        ->when($this->filter_estado != 'Todos', function ($query) {
            $query->when($this->filter_estado != 'Pendiente', function ($query) {
                $query->where('is_confirmado', $this->filter_estado == 'Confirmado' ? true : false);
            });
        })
        ->when(strlen($this->search) > 2, function($q) use ($search){
            $q->whereHas('pasajero_nuevo', function ($query) use ($search) {
                $query->filterDatatable($search);
            })
            ->orWhereHas('pasajero_anterior', function ($query) use ($search) {
                $query->filterDatatable($search);
            })
            ;
        })
        ->when($this->desde, function ($query) {
            $query->whereDate('created_at', '>=', $this->desde);
        })
        ->when($this->hasta, function ($query) {
            $query->whereDate('created_at', '<=', $this->hasta);
        })
        ->when($this->tipo_documento_id, function ($query) {
            $query->whereHas('pasajero_nuevo', function ($query) {
                $query->whereTipoDocumentoId($this->tipo_documento_id);
            });
        })
        ->when($this->nro_documento, function ($query) {
            $query->whereHas('pasajero_nuevo', function ($query) {
                $query->where('nro_doc', 'ilike', "%{$this->nro_documento}%");
            });
        })
        ->withTrashed()
        ->paginate($this->nro_pagination);
    }


    public function confirmar(PasajeCambio $cambio){
        $update_cambio = $cambio;
        $update_cambio->is_confirmado = true;
        $update_cambio->user_autorize_id = Auth::user()->id;
        $update_cambio->fecha_autorize = date('Y-m-d H:i:s');
        $update_cambio->save();

        if($cambio->pasaje){
            $cambio->pasaje->venta_detalle->update([
                'descripcion' => "Pasaje - {$cambio->pasaje->fecha_vuelo} - {$cambio->pasaje->nombre_short} - {$cambio->pasaje->vuelo_desc}"
            ]);
        }

        if($cambio->tipo_pasaje_cambio->descripcion === 'Cambio de ruta' && $cambio->importe_total > 0){
            $venta = Venta::create([
                'clientable_id' => $cambio->pasaje->pasajero_id,
                'clientable_type' => get_class($cambio->pasaje->pasajero)
            ]);

            $venta->detalle()->create([
                'cantidad'      => 1,
                'descripcion'   => "Cambio de ruta - Pasaje {$this->pasaje->codigo}
                    - {$this->pasaje->nombre_short}",
                'monto'         => $this->importe_total,
                // 'monto'         => $tcs->getMontoSoles($pasaje_cambio->importe_penalidad),
                // 'monto_dolares' => $pasaje_cambio->importe_penalidad,
                // 'tasa_cambio'   => $tcs->tasa_cambio,
                'documentable_id'   => $cambio->id,
                'documentable_type' => get_class($cambio),
            ]);
        }

        $this->emit('notify', 'success', 'Se confirmó el cambio de pasaje.');
    }
    public function denegar(PasajeCambio $cambio){
        // $cambio->is_rechazado = true;
        $cambio->is_confirmado = false;
        $cambio->user_autorize_id = Auth::user()->id;
        $cambio->fecha_autorize = date('Y-m-d H:i:s');
        $cambio->save();

        // TODO: Reestablecer el pasaje a como estaba antes de la modificación.

        if($cambio->tipo_pasaje_cambio->descripcion === 'Cambio de titular'){
            $cambio->pasaje->pasajero_id = $cambio->pasajero_anterior_id;
            $cambio->pasaje->save();
        }
        // 'Cambio de ruta'
        if($cambio->tipo_pasaje_cambio->descripcion === 'Cambio de fecha'
            || $cambio->tipo_pasaje_cambio->descripcion === 'Cambio de ruta'){

            $cambio->pasaje->pasaje_vuelos()->delete();

            // CREAR VUELOS EN PasajeCambioVuelo con los vuelos seleccionados como is_anterior = false
            foreach ($cambio->pasaje_cambio_vuelos_anteriores as $vuelo_anterior) {
                PasajeVuelo::create([
                    'pasaje_id' => $cambio->pasaje->id,
                    'vuelo_id'  => $vuelo_anterior['vuelo']['id'],
                ]);
            }
            // $cambio->pasaje->pasajero_id = $cambio->pasajero_anterior_id;
            // $cambio->pasaje->save();
        }

        $cambio->delete();


        $this->emit('notify', 'success', 'Se denegó el cambio de pasaje.');
    }
}
