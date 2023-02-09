<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components\SectionIncidencias;

use App\Models\IncidenciaFecha;
use App\Models\Vuelo;
use DateTime;
use Livewire\Component;

class SectionIncidenciaFecha extends Component
{
    public Vuelo $vuelo;
    public $fecha_hora_vuelo_programado;
    public $fecha_hora_aterrizaje_programado;
    public string $descripcion = '';
    public function render(){
        return view('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-fecha');
    }
    public function registrarIncidenciaFecha(){
        $data = $this->validate([
            'fecha_hora_vuelo_programado'       => 'date',
            'fecha_hora_aterrizaje_programado'  => 'date',
            'descripcion'                       => 'nullable'
        ]);

        $fecha_vuelo = strtotime($this->fecha_hora_vuelo_programado);
        $fecha_aterrizaje = strtotime($this->fecha_hora_aterrizaje_programado);
        if($fecha_vuelo > $fecha_aterrizaje){
            $this->emit('notify', 'error', 'La fecha de vuelo es posterior al de aterrizaje.');
            return;
        }

        $fecha_hora_vuelo_anterior      = $this->vuelo->fecha_hora_vuelo_programado;
        $fecha_hora_aterrizaje_anterior = $this->vuelo->fecha_hora_aterrizaje_programado;
        $this->vuelo->update($data);

        IncidenciaFecha::create([
            'vuelo_id'                          => $this->vuelo->id,
            'fecha_hora_vuelo_anterior'         => $fecha_hora_vuelo_anterior,
            'fecha_hora_aterrizaje_anterior'    => $fecha_hora_aterrizaje_anterior,
            'fecha_hora_vuelo_posterior'        => $this->fecha_hora_vuelo_programado,
            'fecha_hora_aterrizaje_posterior'   => $this->fecha_hora_aterrizaje_programado,
            'descripcion'                       => $this->descripcion
        ]);

        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
        $this->emit('refreshVuelo');
        $this->vuelo->refresh();
    }
    public function getCanRegistrarIncidenciaProperty(){
        return !$this->vuelo->is_closed;
    }
}
