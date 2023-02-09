<?php

namespace App\Http\Livewire\Intranet\Components;

use App\Models\Persona;
use App\Services\PersonaService;
use Livewire\Component;

class InputPersona extends Component
{
    public $label = 'Buscar persona';
    public $disabled = false;
    public $isCliente = false; // ESTE ESTADO PERMITE SABER SI BUSCAR CON DNI Y RUC O SOLO CON DNI SI ES FALSO, PARA OTROS CASOS COMO REGISTRO DE PASAJES QUE NO SE REQUIERE RUC
    public $tipoCliente = 'persona_natural';
    public $search = '';
    public $emitEvent = 'personaFounded';
    public $createPersonaModal = '#createPersonaModal';
    public $is_manually = false;
    public $personaFounded = null;
    public $noRuc = false;

    public $listeners = [
        'personaCreated'            => 'setPersonaCreated',
        'createPersonaCancelled'    => "setManuallyFalse"
    ];

    public function render()
    {
        return view('livewire.intranet.components.input-persona');
    }
    public function searchPersona(){

        if($this->tipoCliente == 'persona_natural'){
            $persona = PersonaService::searchPersona($this->search);
        }else{
            $persona = PersonaService::searchEmpresa($this->search);
        }

        if(!$persona){
            $this->emit('notify', 'error', 'No se encontró resultados');
            return;
        }

        $this->personaFounded = $persona;

        $this->return();
    }

    public function setPersonaCreated(Persona $persona){
        $this->personaFounded = $persona;
        $this->return();
    }
    public function return(){
        $this->emit($this->emitEvent, $this->personaFounded->id, $this->tipoCliente);
    }

    public function setManually($val = true){
        $this->is_manually = $val;
    }
    public function setManuallyFalse(){
        $this->is_manually = false;
    }
}
