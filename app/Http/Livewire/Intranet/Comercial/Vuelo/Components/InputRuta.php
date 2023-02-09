<?php

namespace App\Http\Livewire\Intranet\Comercial\Vuelo\Components;

use App\Models\Ruta;
use Livewire\Component;

class InputRuta extends Component
{
    public $tipo_vuelo_id;
    public $origen_id;
    public $search_ruta;
    public $justComercial = false;
    public $type = 'comercial';
    public function mount(){
        // origen_id
    }
    public function render()
    {
        // $search = '%'.$this->search_ruta .'%';
        $ubicacions = [];
        $rutas = [];

        if(strlen($this->search_ruta) > 2){
            $rutas_desc = explode("-", $this->search_ruta);
            $origen_desc = $rutas_desc[0];
            $destinable_desc = '';
            if(count($rutas_desc) > 1){
                $destinable_desc = $rutas_desc[1];
            }
            $rutas = Ruta::when(isset($this->tipo_vuelo_id), function($q){
                    $q->whereTipoVueloId($this->tipo_vuelo_id);
                })
                ->whereHasOrigenUBigeo('%'.$origen_desc.'%')
                ->when(isset($destinable_desc), function($q) use ($destinable_desc){
                    $q->whereDestinableUbigeo('%'.$destinable_desc.'%');
                })
                ->when($this->justComercial, function($q){
                    $q->whereIsComercial();
                })
                ->when($this->type == 'no-regular', function($q){
                    $q->whereIsNoRegular();
                })
                ->get();
        }

        return view('livewire.intranet.comercial.vuelo.components.input-ruta', compact('rutas'));
    }
    public function selectRuta($id){
        $this->emit('rutaSelected', $id);
        $this->search_ruta = '';
    }
}
