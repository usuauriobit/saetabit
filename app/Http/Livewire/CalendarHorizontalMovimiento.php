<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Vuelo;
use Carbon\Carbon;
use Livewire\Component;

class CalendarHorizontalMovimiento extends Component
{
    public Caja $caja;
    public $days = [];
    public $selected_day = null;
    public $dias = [
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miercoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo',
    ];
    public $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    public function mount($selected_day = null){
        if(is_null($selected_day))
            $this->selected_day = Carbon::now()->format('Y-m-d');
        else
            $this->selected_day = $selected_day;
        $monday = Carbon::parse($this->selected_day)->is('Monday')
                    ? Carbon::parse($this->selected_day)
                    : Carbon::parse($this->selected_day)->previous('Monday');

        $this->setWeek($monday);

    }
    public function render()
    {
        return view('livewire.calendar-horizontal-movimiento');
    }
    public function setWeek($monday){
        $this->days[0] = [
            'date' => $monday->format('Y-m-d'),
            'dia' => $this->dias[$monday->format('l')],
            'd' => $monday->format('d'),
            'mes' => $this->meses[$monday->format('m')-1],
            // 'nro_vuelos' => Vuelo::whereDate('fecha_hora_vuelo_programado', $monday->format('Y-m-d'))->count()
        ];

        for ($i=1; $i <= 6; $i++) {
            $date = Carbon::parse($this->days[0]['date'])->addDays($i);
            $this->days[$i] = [
                'date' => $date->format('Y-m-d'),
                'dia' => $this->dias[$date->format('l')],
                'd' => $date->format('d'),
                'mes' => $this->meses[$date->format('m')-1],
                // 'nro_vuelos' => Vuelo::whereDate('fecha_hora_vuelo_programado', $date->format('Y-m-d'))->count()
            ];
        }
    }
    public function setDaysBefore(){
        $monday = Carbon::parse($this->days[0]['date'])->previous('Monday');
        $this->setWeek($monday);
    }
    public function setDaysAfter(){
        $monday = Carbon::parse($this->days[0]['date'])->next('Monday');
        $this->setWeek($monday);
    }
    public function setDay($day){
        $this->selected_day = Carbon::parse($day)->format('Y-m-d');
        $this->emit('daySelected', $this->selected_day);
    }
}
