<?php

namespace App\Http\Livewire\Intranet\Comercial\PasajeCambio\Create;

use App\Models\Pasaje;
use App\Models\PasajeCambio;
use App\Models\PasajeCambioTarifa;
use App\Models\PasajeCambioVuelo;
use App\Models\PasajeVuelo;
use App\Models\TipoPasajeCambio;
use App\Models\Venta;
use App\Models\Vuelo;
use App\Services\TasaCambioService;
use App\Services\VueloService;
use Livewire\Component;

class CambioFecha extends Component
{
    public Pasaje $pasaje;

    public $fecha_filter;
    public $vuelos_founded= [];

    public $vuelos_selected  = [];

    public $approved_by_id = null;
    public $approved_observation = null;

    public $pasaje_id;
    public $nota = '';
    public $is_sin_pagar = false;
    public $monto = 0;

    public function rules(){
        return [
            'pasaje_id'    => 'required',
            'tipo_pasaje_cambio_id'    => 'required',
            'nota'              => $this->is_sin_pagar ? 'required' : 'nullable',
            'is_sin_pagar'      => 'nullable',
            'approved_by_id'    => 'nullable',
            'approved_observation' => 'nullable'
        ];
    }
    public $listeners = [
        'vueloSelectedFecha' => 'setVuelos',
        'passwordConfirmed' => 'saveCambioFecha'
    ];

    public function mount($pasaje_id){
        $this->pasaje_id = $pasaje_id;
        $this->pasaje = Pasaje::find($pasaje_id);
        $this->tipo_pasaje_cambio_id = TipoPasajeCambio::whereDescripcion('Cambio de fecha')->first()->id;

        $this->monto = PasajeCambioTarifa::whereHas('categoria_vuelo', function($q){
            return $q->where('descripcion', optional($this->pasaje->tipo_vuelo)->descripcion);
        })->first()->monto_cambio_fecha ?? null;
    }
    public function render(){
        return view('livewire.intranet.comercial.pasaje-cambio.create.cambio-fecha');
    }
    public function getImportePenalidadProperty(){
        return $this->is_sin_pagar ? 0 : $this->monto;
    }
    public function saveCambioFecha($_ = null, $observacion = null, $userId = null){
        $this->approved_by_id = $userId;
        $this->approved_observation = $observacion;

        if(count($this->vuelos_selected) == 0){
            $this->emit('notify','error', 'Selecciona el nuevo vuelo');
            return;
        }

        $data = $this->validate();

        // REGISTRA EL CAMBIO EN PASAJE
        $pasaje_cambio = PasajeCambio::create(array_merge($data, [
            'is_confirmado' => true,
            'importe_penalidad' => $this->importe_penalidad
        ]));

        // OBTENER LOS VUELOS ACTUALES
        $vuelos_actuales = $this->pasaje->vuelos;

        // CREAR VUELOS EN PasajeCambioVuelo con los vuelos actuales como vuelos anteriores
        foreach ($vuelos_actuales as $vuelo) {
            PasajeCambioVuelo::create([
                'vuelo_id'          => $vuelo->id,
                'pasaje_cambio_id'  => $pasaje_cambio->id,
                'is_anterior'       => true,
            ]);
        }


        // ELIMINAR LOS VUELOS ACTUALES
        $this->pasaje->pasaje_vuelos()->delete();

        // CREAR VUELOS EN PasajeCambioVuelo con los vuelos seleccionados como is_anterior = false
        foreach ($this->vuelos_selected as $vuelo) {
            PasajeCambioVuelo::create([
                'vuelo_id'          => $vuelo['id'],
                'pasaje_cambio_id'  => $pasaje_cambio->id,
                'is_anterior'       => false,
            ]);
            PasajeVuelo::create([
                'pasaje_id' => $this->pasaje->id,
                'vuelo_id'  => $vuelo['id'],
            ]);
        }
        // REGISTRAR EL PAGO
        $tcs = new TasaCambioService();

        $venta = Venta::create([
            'clientable_id' => $this->pasaje->pasajero_id,
            'clientable_type' => get_class($this->pasaje->pasajero)
        ]);

        $venta->detalle()->create([
            'cantidad'      => 1,
            'descripcion'   => "Cambio de fecha - Pasaje {$this->pasaje->codigo}",
            'monto'         => $this->importe_penalidad,
            // 'monto_dolares' => $pasaje_cambio->importe_penalidad,
            // 'tasa_cambio'   => $tcs->tasa_cambio,
            'documentable_id'   => $pasaje_cambio->id,
            'documentable_type' => get_class($pasaje_cambio),
        ]);

        $this->emit('pasajeCambioSetted');
        $this->emit('closeModals');
        $this->emit('notify','success', 'Se registró el cambio de fecha correctamente');


    }

    public function search(){
        if(!$this->fecha_filter){
            $this->emit('notify', 'error', 'Ingrese una fecha correcta');
            return;
        }

        // BUSCAR VUELOS CON LA MISMA RUTA PERO CON DISTINTA FECHA

        $vuelos_founded = Vuelo::searchVuelosInRuta([
            'destino_id' => $this->pasaje->vuelo_destino->destino_id,
            'origen_id' => $this->pasaje->vuelo_origen->origen_id,
            'fecha_ida' => $this->fecha_filter,
        ])->get();

        if($vuelos_founded->count() == 0){
            $this->emit('notify', 'error', 'No se encontraron vuelos programados en esa fecha');
            return;
        }

        $this->vuelos_founded = [];
        foreach ($vuelos_founded as $vuelo) {
            $this->vuelos_founded[] = VueloService::generarVuelosAgrupados($vuelo, $this->pasaje->vuelo_origen->origen);
        }
    }

    public function setVuelos($vuelos) {
        $this->vuelos_selected = array_map(fn($v) => Vuelo::find($v['id']), $vuelos);
    }

    public function deleteVuelosSelected(){
        $this->vuelos_selected = [];
    }

    // public function getVuelosSelectedModelProperty(){
    //     $vuelos = [];
    //     $vuelos = array_map(fn($v) => Vuelo::find($v['id']), $this->vuelos_selected);

    //     return $vuelos;
    // }
}
