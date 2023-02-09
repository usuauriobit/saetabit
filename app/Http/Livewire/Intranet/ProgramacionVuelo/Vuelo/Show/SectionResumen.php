<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\Show;

use App\Models\Vuelo;
use App\Services\VueloService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class SectionResumen extends Component
{
    public Vuelo $vuelo;
    public $monitoreo_form = [
        'hora_despegue' => null,
        'hora_aterrizaje' => null,
    ];
    public $close_form = ['password' => ''];

    public $listeners = [
        'cerrarVuelo' => 'closeFlight',
        'reabrirVuelo'
    ];
    public $error_hora_aterrizaje = null;

    public function mount(){
        $this->monitoreo_form['hora_despegue'] = optional($this->vuelo->hora_despegue)->format('H:i')
            ?? optional($this->vuelo->fecha_hora_vuelo_programado)->format('H:i');

        $this->monitoreo_form['hora_aterrizaje'] = optional($this->vuelo->hora_aterrizaje)->format('H:i')
            ?? optional($this->vuelo->fecha_hora_aterrizaje_programado)->format('H:i');

    }
    public function render()
    {
        // $this->monitoreo_form['hora_aterrizaje'] = optional($this->vuelo->hora_aterrizaje)->format('Y-m-d H:i')
        //                                         ?? optional($this->vuelo->fecha_hora_aterrizaje_programado)->format('Y-m-d H:i');

        return view('livewire.intranet.programacion-vuelo.vuelo.show.section-resumen');
    }
    public function getHoraAterrizajeProperty(){
        try {
            $hora_aterrizaje = VueloService::calcularHoraAtterizajeVuelo(
                vuelo: $this->vuelo,
                fecha_despegue: $this->monitoreo_form['hora_despegue'],
                with_fecha: false
            );
            return $hora_aterrizaje;
        } catch (\Throwable $th) {
            $this->error_hora_aterrizaje = $th->getMessage();
        }
        return null;
    }
    public function closeFlight(){
        $this->vuelo->update([
            'hora_despegue' => $this->monitoreo_form['hora_despegue'],
            'hora_aterrizaje' => $this->hora_aterrizaje,
            'is_closed' => true
        ]);
        $this->emit('refreshVuelo');
        $this->emit('notify', 'success', 'Vuelo cerrado correctamente');
    }
    public function setMonitoreo(){
        $data = $this->validate([
            'monitoreo_form.hora_despegue' => 'required',
            'monitoreo_form.hora_aterrizaje' => 'required',
        ])['monitoreo_form'];
        // dd($data);
        $this->vuelo->update([
            'hora_despegue' => $this->vuelo->fecha_hora_vuelo_programado->format('Y-m-d') ." ".$data['hora_despegue'],
            'hora_aterrizaje' => $this->vuelo->fecha_hora_vuelo_programado->format('Y-m-d') ." ".$data['hora_aterrizaje'],
        ]);
        $this->vuelo->refresh();
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente.');
    }
    public function reabrirVuelo(){
        $this->vuelo->update([
            'is_closed' => false,
            'hora_despegue' => null,
            'hora_aterrizaje' => null,
        ]);
        $this->vuelo->refresh();
        $this->emit('notify', 'success', 'Se reaperturó el vuelo correctamente.');
    }
}
