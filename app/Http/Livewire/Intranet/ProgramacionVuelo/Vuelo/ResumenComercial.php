<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo;

use App\Models\Vuelo;
use Carbon\Carbon;
use Livewire\Component;

class ResumenComercial extends Component{
    public $fecha_inicio;
    public $fecha_final;
    // public $result;

    public function mount(){
        $this->fecha_inicio = Carbon::now()->format('Y-m-d');
        $this->fecha_final = Carbon::now()->lastOfMonth()->format('Y-m-d');
    }

    public function render(){
        return view('livewire.intranet.programacion-vuelo.vuelo.resumen-comercial', [
            'result' => Vuelo::
            select([
                'id',
                'codigo',
                'fecha_hora_vuelo_programado',
                'fecha_hora_aterrizaje_programado',
                'origen_id',
                'destino_id',
                'nro_asientos_ofertados',
            ])
            ->whereIsComercial()
            ->whereDate('fecha_hora_vuelo_programado', '>=', !empty($this->fecha_inicio) ? $this->fecha_inicio : date('Y-m-d'))
            ->whereDate('fecha_hora_vuelo_programado', '<=', !empty($this->fecha_final_corregido) ? $this->fecha_final_corregido : date('Y-m-d'))
            ->orderBy('fecha_hora_vuelo_programado')
            ->with(['pasajes', 'pasajes.descuento', 'origen', 'destino'])
            ->get()
            ->groupBy([
                fn($i) => $i->ruta_simple."<br>"."<small>(".$i->horario.")</small>",
                fn($i) => optional($i->fecha_hora_vuelo_programado)->format('Y-m-d')
            ])
        ]);
    }
    public function getFechaFinalCorregidoProperty(){
        // dd($this->fecha_final);
        if(empty($this->fecha_final)){
            return Carbon::now()->lastOfMonth()->format('Y-m-d');
        }
        return Carbon::createFromFormat( 'Y-m-d', $this->fecha_final)->addDays(1)->format('Y-m-d');
    }
}
