<?php

namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo;

use App\Models\Avion;
use App\Models\TipoVuelo;
use App\Models\Ubicacion;
use App\Models\Vuelo;
use Livewire\Component;

class Create extends Component
{
    public $tipo_formulario = null;
    public $tipos_supports_massive = [];
    public $tipos_dont_support_massive = [];
    public function mount(){
        $this->tipos_supports_massive = TipoVuelo::whereSupportsMassiveAssign()->get();
        $this->tipos_dont_support_massive = TipoVuelo::whereNotSupportsMassiveAssign()->get();
    }
    public function render()
    {
        return view('livewire.intranet.programacion-vuelo.vuelo.create');
    }
    public function setTypeForm(String $type, TipoVuelo $tipo_vuelo){
        $this->tipo_formulario = $type;
        $this->tipo_vuelo = $tipo_vuelo;
    }
}
