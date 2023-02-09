<?php

namespace App\Http\Livewire\Intranet\TrackingCarga\Components;

use App\Models\GuiaDespacho;
use Livewire\Component;

class FormSearchCarga extends Component
{
    public $codigo_guia_despacho = '';
    public function render()
    {
        return view('livewire.intranet.tracking-carga.components.form-search-carga');
    }
    public function searchCarga(){
        // dd($this->codigo_guia_despacho);
        $guia_despacho = GuiaDespacho::whereCodigo($this->codigo_guia_despacho)->first();

        if(!$guia_despacho){
            $this->emit('notify', 'error', 'No se encontró ninguna guía de despacho');
            return;
        }

        $this->emit('guiaDespachoFounded', $guia_despacho);
    }
}
