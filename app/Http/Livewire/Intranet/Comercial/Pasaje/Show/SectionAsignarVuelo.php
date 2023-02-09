<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasaje\Show;

use App\Models\Pasaje;
use App\Models\PasajeLiberacionHistorial;
use App\Models\PasajeVuelo;
use App\Models\Ubicacion;
use App\Models\Vuelo;
use App\Services\VueloService;
use Livewire\Component;

class SectionAsignarVuelo extends Component
{
    public Pasaje $pasaje;
    public $vuelos_selected  = [];
    public $vuelos_founded= [];
    public $fecha_filter;
    public $tab;
    public $listeners = [
        // 'vuelosFounded' => 'setVuelos',
        'vueloSelectedRuta' => 'setVueloSelected'
    ];

    public function mount(){
        $this->tab = $this->pasaje->is_abierto ? 'formulario' : 'historial';
    }

    public function render(){
        return view('livewire.intranet.comercial.pasaje.show.section-asignar-vuelo');
    }

    public function searchVuelos() {

        if(!$this->fecha_filter){
            $this->emit('notify','error', 'Ingrese una fecha correctamente');
            return;
        }

        $this->vuelos_founded = Vuelo::searchVuelosInRuta([
            'destino_id' => $this->pasaje->destino_id,
            'origen_id' => $this->pasaje->origen_id,
            'fecha_ida' => $this->fecha_filter,
        ])
        ->get()
        ->filter(fn($vuelo) => $vuelo->destino_id == $this->pasaje->destino_id)
        ->map(fn($vuelo) => VueloService::generarVuelosAgrupados(Vuelo::find($vuelo->id), $this->pasaje->origen) );

        if(count($this->vuelos_founded) == 0){
            $this->emit('notify', 'error', 'No se encontraron vuelos en la fecha seleccionada');
        }

    }
    public function setVueloSelected($vuelos){
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

    public function save(){
        $codigo_liberacion = uniqid();

        $pasaje_vuelos = [];
        foreach ($this->vuelos_selected_model as $vuelo) {
            $pasaje_vuelos[] = PasajeVuelo::create([
                'pasaje_id' => $this->pasaje->id,
                'vuelo_id' => $vuelo->id,
            ]);
        }
        foreach ($pasaje_vuelos as $pasaje_vuelo) {
            PasajeLiberacionHistorial::create([
                'pasaje_id'         => $this->pasaje->id,
                'pasaje_vuelo_nuevo_id'   => $pasaje_vuelo->id,
                'codigo_historial'  => $codigo_liberacion,
            ]);
        }

        $this->pasaje->update([
            'is_abierto' => false
        ]);

        $this->pasaje->refresh();
        $this->pasaje->venta_detalle->update([
            'descripcion' => "Pasaje - {$this->pasaje->fecha_vuelo} - {$this->pasaje->vuelo_desc} - {$this->pasaje->nombre_short}"
        ]);

        $this->emit('notify','success', 'Se asignó el pasaje correctamente a un vuelo');
        $this->emit('pasajeChanged');

        $this->tab == 'historial';
    }

    public function setTab($tab){
        $this->tab = $tab;
    }
}
