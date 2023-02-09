<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vuelo;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $current_date;
    public $listeners = [
        'daySelected' => 'setDay'
    ];
    public function mount(){
        $this->current_date = date('Y-m-d');
    }
    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.programacion-vuelo.vuelo.index', [
            'items' => Vuelo::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q->filterSearch($search);
            })
            ->whereDate('fecha_hora_vuelo_programado', $this->current_date)
            ->paginate($this->nro_pagination),
        ]);
    }
    public function setDay($date){
        $this->current_date = $date;
    }
    public function getFechaProperty(){
        return Carbon::parse($this->current_date)->formatLocalized('%d %B %Y');
    }
}
