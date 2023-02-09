<?php

namespace App\Http\Livewire\LandingPage;

use App\Models\Ubicacion;
use App\Models\Vuelo;
use App\Services\VueloService;
use Carbon\Carbon;
use Livewire\Component;

class AdquirirPasajesPage extends Component {

    public $hasError = false;
    public $errorMsg = '';

    public $vuelos_ida_founded = [];
    public $vuelos_vuelta_founded = [];

    public $vuelos_ida_selected = [];
    public $vuelos_vuelta_selected = [];


    public $ubicacion_origen = null;
    public $ubicacion_destino = null;
    public $is_ida_vuelta = null;
    public $fecha_ida = null;
    public $fecha_vuelta = null;
    public $nro_pasajes = null;

    public $qs_ubicacion_origen_id = null;
    public $qs_ubicacion_destino_id = null;
    public $qs_is_ida_vuelta = null;
    public $qs_fecha_ida = null;
    public $qs_fecha_vuelta = null;
    public $qs_nro_pasajes = null;

    public $tarifas_ida = [];
    public $tarifas_vuelta = [];

    protected $queryString = [
        'qs_ubicacion_origen_id',
        'qs_ubicacion_destino_id',
        'qs_is_ida_vuelta',
        'qs_fecha_ida',
        'qs_fecha_vuelta',
        'qs_nro_pasajes',
    ];

    public $listeners = [
        'searchVuelosEvent',
        'vueloSelected',
        'setTab',
        'setTarifas',
        'hasError'
    ];
    private function _loadQueryString(){
        // dd($this->qs_ubicacion_destino_id);
        if($this->qs_ubicacion_origen_id){
            $this->ubicacion_origen = Ubicacion::find($this->qs_ubicacion_origen_id);
            $this->ubicacion_destino = Ubicacion::find($this->qs_ubicacion_destino_id);
            $this->is_ida_vuelta = $this->qs_is_ida_vuelta;
            $this->fecha_ida = $this->qs_fecha_ida;
            $this->fecha_vuelta = $this->qs_fecha_vuelta;
            $this->nro_pasajes = $this->qs_nro_pasajes;
        }
    }
    public function mount(){

        setlocale(LC_ALL,"es_ES");
        Carbon::setLocale('es');
        $this->_loadQueryString();

        if(
            $this->ubicacion_origen &&
            $this->ubicacion_destino &&
            $this->fecha_ida &&
            $this->nro_pasajes
        ){
            $this->search();
        }
    }

    public function render(){
        return view('livewire.landing-page.adquirir-pasajes-page');
    }
    public function searchVuelosEvent($data){
        $this->ubicacion_origen = Ubicacion::find($data['ubicacion_origen_id']);
        $this->ubicacion_destino = Ubicacion::find($data['ubicacion_destino_id']);
        $this->is_ida_vuelta = $data['is_ida_vuelta'];
        $this->fecha_ida = $data['fecha_ida'];
        $this->fecha_vuelta = $data['fecha_vuelta'];
        $this->nro_pasajes = $data['nro_pasajes'];

        $this->search();

    }
    private function search(){
        $ida_vuelos_founded_id = Vuelo::whereIsComercial()
            ->searchVuelosInRuta([
                'destino_id' => $this->ubicacion_destino->id,
                'origen_id' => $this->ubicacion_origen->id,
                'fecha_ida' => $this->fecha_ida,
            ])
            ->get()
            ->filter(fn($vuelo) => $vuelo->destino_id == $this->ubicacion_destino->id)
            ->map(fn($v) => $v['id']);

        $this->vuelos_ida_founded = Vuelo::find($ida_vuelos_founded_id)
            ->map(fn($v) => VueloService::generarVuelosAgrupados($v, $this->ubicacion_origen))
            ->toArray();
        if($this->is_ida_vuelta){
            $vuelta_vuelos_founded_id = Vuelo::whereIsComercial()
            ->searchVuelosInRuta([
                'destino_id' => $this->ubicacion_origen->id,
                'origen_id' => $this->ubicacion_destino->id,
                'fecha_ida' => $this->fecha_vuelta,
            ])
            ->get()
            ->filter(fn($vuelo) => $vuelo->destino_id == $this->ubicacion_origen->id)
            ->map(fn($v) => $v['id']);

            $this->vuelos_vuelta_founded = Vuelo::find($vuelta_vuelos_founded_id)
                    ->map(fn($v) => VueloService::generarVuelosAgrupados($v, $this->ubicacion_destino))
                    ->toArray();
        }
    }
    public function getFechaIdaObjProperty(){
        return $this->fecha_ida ? Carbon::create($this->fecha_ida) : null;
    }
    public function getFechaVueltaObjProperty(){
        return $this->fecha_vuelta ? Carbon::create($this->fecha_vuelta) : null;
    }

    public function vueloSelected($params){
        $this->{'vuelos_'.$params['type'].'_selected'} = $this->{'vuelos_'.$params['type'].'_founded'}[$params['index']];
    }
    public function setTarifas($tarifas_ida, $tarifas_vuelta){
        $this->tarifas_ida = $tarifas_ida;
        $this->tarifas_vuelta = $tarifas_vuelta;
    }
    public function getTypeProperty(){
        return $this->is_ida_vuelta ? ['ida', 'vuelta'] : ['ida'] ;
    }

    public function hasError($msg){
        $this->hasError = true;
        $this->errorMsg = $msg;
    }

}
