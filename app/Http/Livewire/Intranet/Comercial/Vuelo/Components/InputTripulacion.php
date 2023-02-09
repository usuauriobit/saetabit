<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components;

use App\Models\TipoTripulacion;
use App\Models\Tripulacion;
use Livewire\Component;

class InputTripulacion extends Component
{
    public $search_tripulacion = '';
    public $type;
    public TipoTripulacion $tipo_tripulacion;
    public $sendEvent = 'tripulacionSelected';
    public $emitUp = false;
    public function mount(){
        $this->tipo_tripulacion = TipoTripulacion::whereDescripcion($this->type)->first();
    }
    public function render()
    {
        $search = '%'.$this->search_tripulacion .'%';
        $results = [];
        if(strlen($this->search_tripulacion) > 3){
            $results = Tripulacion::whereNombreLike($search)
                ->where('tipo_tripulacion_id', $this->tipo_tripulacion->id)
                ->get();
        }
        $results = Tripulacion::where('tipo_tripulacion_id', $this->tipo_tripulacion->id)
            ->when(strlen($this->search_tripulacion) > 3, function($q) use($search){
                $q->whereNombreLike($search);
            })
            ->when(strlen($this->search_tripulacion) <= 3, function($q) use($search){
                $q->limit(5);
            })
            ->get();
        return view('livewire.intranet.comercial.vuelo.components.input-tripulacion', compact('results'));
    }
    public function selectTripulacion($id){
        if($this->emitUp){
            $this->emitUp($this->sendEvent, $id);
        }else{
            $this->emit($this->sendEvent, $id);
        }
    }
}
