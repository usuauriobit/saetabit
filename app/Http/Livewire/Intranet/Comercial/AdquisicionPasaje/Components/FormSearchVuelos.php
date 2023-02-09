<?php

namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Components;

use App\Models\Ruta;
use App\Models\TipoVuelo;
use App\Models\Ubicacion;
use App\Models\Vuelo;
use Livewire\Component;

class FormSearchVuelos extends Component {
    public $tipo_vuelos;

    public ?Ubicacion $destino = null;
    public ?Ubicacion $origen = null;
    public $fecha_ida = null;
    public $fecha_vuelta = null;
    public $tipo_vuelo_id;
    public string $type_search = 'ida';

    public $withPasajeAbiertoEmit = false;

    public $rutaOpenned = false;
    public $noCharter = false;

    public $tab = 'filtro';
    public $codigo_vuelo = '';

    public $listeners = [
        'rutaSelected' => 'setRuta',
        'ubicacionSelected' => 'setUbicacion',
    ];

    public function mount(){
        $this->fecha_ida  = date('Y-m-d');
        $this->tipo_vuelos = TipoVuelo::when($this->noCharter, fn($q) => $q->whereIsNotCharter())->get();
        $this->tipo_vuelo_id = TipoVuelo::whereDescripcion('Comercial')->whereIsNotCharter()->first()->id;

    }
    public function render()
    {
        return view('livewire.intranet.comercial.adquisicion-pasaje.components.form-search-vuelos');
    }

    public function deleteUbicacion($type){
        $type == 'origen'
            ? $this->origen = null
            : $this->destino = null;
    }
    public function toogleRutaOpenned(){
        $this->rutaOpenned = !$this->rutaOpenned;
    }
    public function searchVuelos(){

        if($this->tab == 'codigo'){
            $vuelo = Vuelo::whereCodigo($this->codigo_vuelo)->first();
            if(!$vuelo){
                $this->emit('notify', 'error', 'No se encontró ningún vuelo con el código ingresado');
                return;
            }

            $this->type_search = 'ida';
            $this->emit('vuelosFounded',
                $this->type_search,
                $vuelo->tipo_vuelo,
                $vuelo->origen,
                $vuelo->destino,
                [$vuelo->id],
                []
            );
            return;
        }

        $data = $this->validate([
            'destino.id' => 'required',
            'origen.id' => 'required',
            'fecha_ida' => 'required',
            'fecha_vuelta' => $this->type_search == 'ida' ? 'nullable' : 'required',
            'tipo_vuelo_id' => 'required',
        ]);

        // TODO: Funciona, pero no está del todo bien, debería optimizarse o buscar otra forma de hacer la búsqueda
        // SI SE EDITA AQUÍ TAMBIEN EDIITAR EN PASAJE/SHOW/SECTION_ASIGNAR_VUELO
        $ida_vuelos_founded = Vuelo::searchVuelosInRuta([
            'destino_id' => $data['destino']['id'],
            'origen_id' => $data['origen']['id'],
            'fecha_ida' => $data['fecha_ida'],
        ])
        ->get()
        ->filter(fn($vuelo) => $vuelo->destino_id == $data['destino']['id']);



        if(count($ida_vuelos_founded) == 0){
            $this->emit('notify', 'error', 'No se encontraron vuelos de ida. Pruebe con una fecha distinta');
            return;
        }

        $vuelta_vuelos_founded = collect();
        if($this->type_search == 'ida_vuelta'){
            $vuelta_vuelos_founded = Vuelo::searchVuelosInRuta([
                'destino_id' => $data['origen']['id'],
                'origen_id' => $data['destino']['id'],
                'fecha_ida' => $data['fecha_vuelta'],
            ])
            ->get()
            ->filter(fn($vuelo) => $vuelo->destino_id == $data['origen']['id']);

            if(count($vuelta_vuelos_founded) == 0){
                $this->emit('notify', 'error', 'No se encontraron vuelos de vuelta. Pruebe con una fecha distinta');
                return;
            }
        }

        $ida_ids = $ida_vuelos_founded->map(fn($v) => $v['id']);
        $vuelta_ids = $vuelta_vuelos_founded->map(fn($v) => $v['id']);
        $this->emit('vuelosFounded',
            $this->type_search,
            $this->tipo_vuelo,
            $this->origen,
            $this->destino,
            $ida_ids,
            $vuelta_ids ?? null
        );
    }

    public function changeTipoVuelo(TipoVuelo $tipoVuelo){
        $this->tipo_vuelo = $tipoVuelo;
    }
    public function setUbicacion($type, Ubicacion $ubicacion){
        $type == 'origen'
            ? $this->origen = $ubicacion
            : $this->destino = $ubicacion;
    }
    public function setRuta(Ruta $ruta){
        $this->origen = optional($ruta->tramo)->origen;
        $this->destino = optional($ruta->tramo)->destino;
    }

    public function getTipoVueloProperty(){
        return TipoVuelo::find($this->tipo_vuelo_id);
    }

    public function setTab($tab){
        $this->tab = $tab;
    }
    public function setAsLibre(){
        $this->emit('libreSetted', $this->tipo_vuelo_id, $this->origen, $this->destino);
    }
}
