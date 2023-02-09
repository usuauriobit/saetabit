<?php

namespace App\Http\Livewire\Intranet\TrackingCarga;

use App\Models\GuiaDespacho;
use Livewire\Component;

class Index extends Component
{
    public $guia_despacho_founded = null;
    public $listeners = [
        'guiaDespachoFounded' => 'setGuiaDespacho'
    ];
    public function render()
    {
        return view('livewire.intranet.tracking-carga.index');
    }
    public function setGuiaDespacho(GuiaDespacho $guia_despacho){
        $this->guia_despacho_founded = $guia_despacho;
    }
}
