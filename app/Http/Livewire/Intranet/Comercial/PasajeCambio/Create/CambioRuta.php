<?php

namespace App\Http\Livewire\Intranet\Comercial\PasajeCambio\Create;

use App\Models\Pasaje;
use App\Models\PasajeCambio;
use App\Models\PasajeCambioTarifa;
use App\Models\PasajeCambioVuelo;
use App\Models\PasajeVuelo;
use App\Models\Ruta;
use App\Models\Tarifa;
use App\Models\TipoPasajeCambio;
use App\Models\Ubicacion;
use App\Models\Venta;
use App\Models\Vuelo;
use App\Services\TasaCambioService;
use App\Services\VueloService;
use Livewire\Component;

class CambioRuta extends Component
{
    public Pasaje $pasaje;

    public $ruta_filter;
    public $vuelos_founded= [];

    public $vuelos_selected  = [];

    public $importe_penalidad = 0;
    public $nota = '';
    public $is_sin_pagar = false;

    public $approved_by_id = null;
    public $approved_observation = null;

    // public $monto = 0;

    public $rules = [
        'pasaje_id'    => 'required',
        'tipo_pasaje_cambio_id'    => 'required',
        // 'importe_penalidad' => 'nullable|numeric|min:0',
        'nota'              => 'nullable',
        'is_sin_pagar'      => 'nullable',
    ];

    public $listeners = [
        'vuelosFounded' => 'setVuelos',
        'vueloSelectedRuta' => 'setVueloSelected',
        'passwordConfirmed' => 'saveCambioTitularidad'
    ];

    public function mount(){
        $this->tipo_pasaje_cambio_id = TipoPasajeCambio::whereDescripcion('Cambio de ruta')->first()->id;
        $this->pasaje_id = $this->pasaje->id;

        $this->importe_penalidad = PasajeCambioTarifa::whereHas('categoria_vuelo', function($q){
            return $q->where('descripcion', optional($this->pasaje->tipo_vuelo)->descripcion);
        })->first()->monto_cambio_ruta;
    }

    public function render(){
        return view('livewire.intranet.comercial.pasaje-cambio.create.cambio-ruta');
    }
    public function saveCambioRuta($_ = null, $observacion = null, $userId = null){
        $this->approved_by_id = $userId;
        $this->approved_observation = $observacion;

        if(count($this->vuelos_selected) == 0){
            $this->emit('notify','error', 'Selecciona el nuevo vuelo');
            return;
        }

        $data = $this->validate();

        $data['is_confirmado'] = true;
        $data['importe_penalidad'] = $this->importe_penalidad;
        if($this->is_sin_pagar){
            $data['importe_penalidad'] = 0;
            // $data['importe_adicional'] = 0;
            $data['is_confirmado'] = false;
        }
        // else{
        //     $data['importe_adicional'] = $this->importe_adicional;
        //     if(!$this->importe_penalidad){
        //         $this->emit('notify','error', 'Ingrese un importe de penalidad correcto');
        //         return;
        //     }
        // }

        // REGISTRA EL CAMBIO EN PASAJE
        $pasaje_cambio = PasajeCambio::create($data);

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
        foreach ($this->vuelos_selected as $vuelo_selected) {
            PasajeCambioVuelo::create([
                'vuelo_id'          => $vuelo_selected['id'],
                'pasaje_cambio_id'  => $pasaje_cambio->id,
                'is_anterior'       => false,
            ]);
            PasajeVuelo::create([
                'pasaje_id' => $this->pasaje->id,
                'vuelo_id'  => $vuelo_selected['id'],
            ]);
        }

        // REGISTRAR EL PAGO
        if(!$this->is_sin_pagar){

            $venta = Venta::create([
                'clientable_id' => $this->pasaje->pasajero_id,
                'clientable_type' => get_class($this->pasaje->pasajero)
            ]);

            $venta->detalle()->create([
                'cantidad'      => 1,
                'descripcion'   => "Cambio de ruta - Pasaje {$this->pasaje->codigo}",
                'monto'         => $this->importe_total,
                // 'monto'         => $tcs->getMontoSoles($pasaje_cambio->importe_penalidad),
                // 'monto_dolares' => $pasaje_cambio->importe_penalidad,
                // 'tasa_cambio'   => $tcs->tasa_cambio,
                'documentable_id'   => $pasaje_cambio->id,
                'documentable_type' => get_class($pasaje_cambio),
            ]);
        }

        $this->pasaje->refresh();

        $this->pasaje->venta_detalle->update([
            'descripcion' => "Pasaje - {$this->pasaje->fecha_vuelo} - {$this->pasaje->vuelo_desc} - {$this->pasaje->nombre_short}"
        ]);

        $this->emit('pasajeCambioSetted');
        $this->emit('closeModals');
        $this->emit('notify','success', 'Se registró el cambio de ruta correctamente');
    }

    public function setVuelos($_, $__, $origen, $destino, $vuelos_id, $_____) {
        $this->vuelos_founded = [];
        foreach ($vuelos_id as $vuelo_id) {
            $this->vuelos_founded[] = VueloService::generarVuelosAgrupados(Vuelo::find($vuelo_id), Ubicacion::find($origen['id']));
        }
    }

    public function setVueloSelected($vuelos){
        // \Debugbar::info('VUELO SELECCIONADO');
        $this->vuelos_selected = $vuelos;
    }

    public function deleteVuelosSelected(){
        $this->vuelos_selected = [];
    }

    public function getVuelosSelectedModelProperty(){
        $vuelos = [];
        $vuelos = array_map(fn($v) => Vuelo::find($v['id']), $this->vuelos_selected);

        return $vuelos;
    }

    public function getTarifaProperty(){
        if(!$this->vuelos_selected_model) return null;
        $ruta = Ruta::whereHas('tramo', function($q){
            $q->where('origen_id', $this->vuelos_selected_model[0]->origen_id)
                ->where('escala_id', isset($this->vuelos_selected_model[1])
                                    ? $this->vuelos_selected_model[0]->origen_id
                                    : null )
                ->where('destino_id', isset($this->vuelos_selected_model[1])
                                    ? $this->vuelos_selected_model[1]->destino_id
                                    : $this->vuelos_selected_model[0]->destino_id );
        })
        ->where('tipo_vuelo_id', $this->vuelos_selected_model[0]->tipo_vuelo_id)->first();
        $tarifa = Tarifa::where('ruta_id', $ruta->id ?? null)
            ->where('tipo_pasaje_id', $this->pasaje->tipo_pasaje_id)
            ->first();
        return $tarifa;
    }
    public function getImporteAdicionalProperty(){
        if(!$this->tarifa) return 0;

        $nuevo_importe = ($this->tarifa->is_dolarizado ? $this->tarifa->precio_soles : $this->tarifa->precio) - $this->pasaje->importe_final_soles;
        return ($nuevo_importe >= 0) ? $nuevo_importe : 0;
    }
    public function getImporteTotalProperty(){
        return $this->importe_adicional + $this->importe_penalidad;
    }


}
