<?php

namespace App\Http\Livewire\LandingPage\Components;

use App\Models\TipoPasaje;
use App\Models\Ubicacion;
use App\Models\Vuelo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormFilter extends Component
{
    public $vertical = true;
    public $ubicacion_origen = null;
    public $ubicaciones_origen = null;
    public $ubicacion_destino = null;
    public $is_ida_vuelta = true;
    public $fecha_ida = null;
    public $fecha_vuelta = null;
    public $fechas_disponibles = [];
    public $tipo_pasajes = null;
    public $nro_pasajes = [];
    public $redirectable = false;

    public function mount(
        $ubicacion_origen = null,
        $ubicacion_destino = null,
        $is_ida_vuelta = true,
        $fecha_ida = null,
        $fecha_vuelta = null,
        $nro_pasajes = [],
    ){

        $this->ubicacion_origen = $ubicacion_origen;
        $this->ubicacion_destino = $ubicacion_destino;
        $this->is_ida_vuelta = $is_ida_vuelta;
        $this->fecha_ida = $fecha_ida;
        $this->fecha_vuelta = $fecha_vuelta;
        $this->nro_pasajes = $nro_pasajes;

        $this->ubicaciones_origen = Ubicacion::whereIsOrigenComercial()->get();
        if(empty($nro_pasajes)){
            $this->generateNroPasajes();
        }
    }
    private function generateNroPasajes(){
        $tipo_pasajes = TipoPasaje::get();
        foreach ($tipo_pasajes as $tipo_pasaje) {
            $this->nro_pasajes[] = [
                'descripcion' => $tipo_pasaje->descripcion,
                'edad_minima' => $tipo_pasaje->edad_minima,
                'edad_maxima' => $tipo_pasaje->edad_maxima,
                'ocupa_asiento' => $tipo_pasaje->ocupa_asiento,
                'nro'         => $tipo_pasaje->descripcion === 'Adulto' ? 1 : 0
            ];
        }
    }
    public function render(){
        return view('livewire.landing-page.components.form-filter');
    }

    public function getUbicacionesDestinoProperty(){
        return Ubicacion::whereIsDestinableFromOrigenComercial(optional($this->ubicacion_origen)->id ?? null)->get();
    }
    public function search(){
        if(!$this->ubicacion_origen) return $this->emit('notify', 'error', 'Seleccione el origen');
        if(!$this->ubicacion_destino) return $this->emit('notify', 'error', 'Seleccione el destino');
        if(!$this->fecha_ida) return $this->emit('notify', 'error', 'Ingrese la fecha de ida');
        if($this->is_ida_vuelta && !$this->fecha_vuelta) return $this->emit('notify', 'error', 'Ingrese una fecha de vuelta');
        if($this->nro_pasajes_total < 0) return $this->emit('notify', 'error', 'Ingrese el número de pasajes');

        if($this->redirectable){
            return redirect()->route('landing_page.adquirir-pasajes', [
                'qs_fecha_ida' => $this->fecha_ida,
                'qs_fecha_vuelta' => $this->fecha_vuelta,
                'qs_nro_pasajes' => $this->nro_pasajes,
                'qs_is_ida_vuelta' => $this->is_ida_vuelta,
                'qs_ubicacion_origen_id' => $this->ubicacion_origen->id,
                'qs_ubicacion_destino_id' => $this->ubicacion_destino->id,
            ]);
        }

        $this->emit('searchVuelosEvent', [
            'ubicacion_origen_id' => $this->ubicacion_origen->id,
            'ubicacion_destino_id' => $this->ubicacion_destino->id,
            'is_ida_vuelta' => $this->is_ida_vuelta,
            'fecha_ida' => $this->fecha_ida,
            'fecha_vuelta' => $this->fecha_vuelta,
            'nro_pasajes' => $this->nro_pasajes,
        ]);
    }
    public function setOrigen(Ubicacion $ubicacion){
        $this->ubicacion_origen = $ubicacion;
        if(!is_null($this->ubicacion_destino)){
            $this->ubicacion_destino = null;
        }
        $this->_buscarFechasDisponibles();
    }
    public function setDestino(Ubicacion $ubicacion){
        $this->ubicacion_destino = $ubicacion;
        $this->_buscarFechasDisponibles();
    }
    public function setIsIdaVuelta(){
        $this->is_ida_vuelta = true;
        $this->fecha_ida = null;
        $this->fecha_vuelta = null;
        $this->emit('type-changed');
    }
    public function setIsSoloIda(){
        $this->is_ida_vuelta = false;
        $this->fecha_ida = null;
        $this->fecha_vuelta = null;
        $this->emit('type-changed');
    }
    public function getNroPasajesTotalProperty(){
        $sum = 0;
        foreach ($this->nro_pasajes as $nro_pasaje) {
            $sum += $nro_pasaje['nro'];
        }
        return $sum;
    }
    public function setNroPasajes($nro_pasajes){
        $this->nro_pasajes = $nro_pasajes;
    }
    private function _buscarFechasDisponibles(){
        if(!$this->ubicacion_destino){
            $this->fechas_disponibles = null;
            return;
        }

        $fechas = Vuelo::whereIsComercial()
            ->searchVuelosInRuta([
                'origen_id' => $this->ubicacion_origen->id,
                'destino_id' => $this->ubicacion_destino->id,
            ])
            ->when($this->is_ida_vuelta, function($q){
                $q->orWhere(function($q){
                    $q->searchVuelosInRuta([
                        'origen_id' => $this->ubicacion_destino->id,
                        'destino_id' => $this->ubicacion_origen->id,
                    ]);
                });
            })
            ->select(DB::raw('DATE(fecha_hora_vuelo_programado) AS fecha'))
            ->groupBy('fecha')
            ->get()
            ->pluck('fecha')
            ->toArray();
        $this->fechas_disponibles = $fechas;
        $this->emit('type-changed');

        return;
    }

}
