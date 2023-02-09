<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components\SectionIncidencias;

use App\Models\IncidenciaEscala;
use App\Models\Ubicacion;
use App\Models\Vuelo;
use App\Models\VueloRuta;
use Livewire\Component;

class SectionIncidenciaRuta extends Component
{
    public Vuelo|VueloRuta $vuelo;
    public Ubicacion|null $escala = null;
    public string $descripcion = '';

    public $fecha_hora_aterrizaje_primero_programado;
    public $fecha_hora_vuelo_programado;
    public $fecha_hora_aterrizaje_ultimo_programado;

    public $listeners = [
        'escalaSelected' => 'setEscala'
    ];

    public function mount(){
        $this->fecha_hora_aterrizaje_primero_programado;
        $this->fecha_hora_vuelo_programado;
        $this->fecha_hora_aterrizaje_ultimo_programado = $this->vuelo->fecha_hora_aterrizaje_programado;
    }

    public function render(){
        return view('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-ruta');
    }

    public function getCanRegistrarIncidenciaProperty(){
        return get_class($this->vuelo) == 'App\Models\Vuelo'
            && $this->vuelo->nro_escalas == 0
            && !$this->vuelo->is_closed;
    }

    public function setEscala($_, Ubicacion $ubicacion){
        if($ubicacion->id == $this->vuelo->origen_id || $ubicacion->id == $this->vuelo->destino_id){
            $this->emit('notify', 'error', 'La escala no puede ser la misma ubicación que el origen o destino');
            return;
        }
        $this->escala = $ubicacion;
        $this->dispatchBrowserEvent('refreshJS');
    }
    public function removeEscala(){
        $this->escala = null;
        $this->dispatchBrowserEvent('refreshJS');
    }

    public function registrarIncidenciaEscala(){
        if(!$this->escala){
            $this->emit('notify','error', 'Debe seleccionar la ubicación de escala');
            return;
        }

        $this->validate([
            'fecha_hora_aterrizaje_primero_programado' => 'required',
            'fecha_hora_vuelo_programado' => 'required',
            'fecha_hora_aterrizaje_ultimo_programado' => 'required',
        ]);

        $destino = $this->vuelo->destino;


        // EDITAR EL DESTINO DEL VUELO ACTUAL CON EL DE LA ESCALA
        $this->vuelo->update([
            'destino_id' => $this->escala->id,
            'fecha_hora_aterrizaje_programado' => $this->vuelo->fecha_hora_vuelo_programado->format('Y-m-d')." ".$this->fecha_hora_aterrizaje_primero_programado
        ]);
        // CREAR UN NUEVO VUELO CON ORIGEN EN ESCALA Y DESTINO COMO EL VUELO ACTUAL, debe pertenecer al mismo vuelo ruta y tener step 2
        $vuelo_secundario = Vuelo::create([
            'vuelo_ruta_id'         => $this->vuelo->vuelo_ruta_id,
            'tipo_vuelo_id'         => $this->vuelo->tipo_vuelo_id,
            'avion_id'              => $this->vuelo->avion_id,
            'origen_id'             => $this->escala->id,
            'destino_id'            => $destino->id,

            'fecha_hora_vuelo_programado'       => $this->fecha_hora_vuelo_programado,
            'fecha_hora_aterrizaje_programado'  => $this->vuelo->fecha_hora_vuelo_programado->format('Y-m-d')." ".$this->fecha_hora_aterrizaje_ultimo_programado,
            'nro_asientos_ofertados'=> $this->vuelo->nro_asientos_ofertados,
            'stop_number'           => $this->vuelo->stop_number+1,
            'is_closed'             => false,
            'vuelo_massive_id'      => $this->vuelo->vuelo_massive_id,
        ]);
        // OBTENER TODOS LOS PASAJES Y AGREGAR EL NUEVO VUELO A SU RELACION PASAJE_VUELO
        foreach ($this->vuelo->pasajes as $pasaje) {
            $pasaje->pasaje_vuelos()->create([
                'vuelo_id' => $vuelo_secundario->id,
            ]);
        }

        // REGISTRAR LA INCIDENCIA EN LA TABLA DE INCIDENCIAS_ESCALA
        IncidenciaEscala::create([
            'descripcion'               => $this->descripcion,
            'vuelo_primario_id'         => $this->vuelo->id,
            'escala_ubicacion_id'       => $this->escala->id,
            'vuelo_secundario_generado_id'=> $vuelo_secundario->id,
        ]);

        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
        $this->emit('refreshVuelo');
        $this->vuelo->refresh();
    }
}
