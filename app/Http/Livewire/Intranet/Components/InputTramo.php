<?php

namespace App\Http\Livewire\Intranet\Components;

use App\Models\Tramo;
use Livewire\Component;

class InputTramo extends Component {

    public $origen_id;
    public $search_tramo;
    public $withEscala = true;
    public function mount(){
        // origen_id
    }
    public function render()
    {
        // $search = '%'.$this->search_tramo .'%';
        $ubicacions = [];
        $tramos = [];

        if(strlen($this->search_tramo) > 2){
            $tramos_desc = explode("-", $this->search_tramo);
            $origen_desc = $tramos_desc[0];
            $destinable_desc = '';
            if(count($tramos_desc) > 1){
                $destinable_desc = $tramos_desc[1];
            }
            $tramos = Tramo::
                whereHasOrigenUBigeo('%'.$origen_desc.'%')
                ->when(isset($destinable_desc), function($q) use ($destinable_desc){
                    $q->whereDestinoUbigeo('%'.$destinable_desc.'%');
                })
                ->when(!$this->withEscala, function($q){
                    $q->whereNull('escala_id');
                })
                ->get();
        }

        return view('livewire.intranet.components.input-tramo', compact('tramos'));
    }
    public function selectTramo($id){
        $this->emit('tramoSelected', $id);
        $this->search_tramo = '';
    }
}
