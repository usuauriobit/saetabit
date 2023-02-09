<?php
namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits;

trait StepperTrait {
    public $step = 1;
    public function backStep(){
        switch ($this->step) {
            case 2:
                if(count($this->all_pasajes_plane) > 0) {
                    $this->emit('notify','error','Ya existe una relación de pasajes asignados según el filtro. Recargue la página para empezar de nuevo');
                    return;
                }
                if($this->alreadySetId){
                    $this->emit('notify','error','Ya hay un vuelo seleccionado, no se puede cambiar esta opción');
                    return;
                }
                break;
        }
        $this->step--;
    }
    public function nextStep(){

        switch ($this->step) {
            case 1:
                if(!$this->has_already_vuelo_selected) {
                    $this->emit('notify','error','Seleccione los vuelos correctamente');
                    return;
                }
                break;
            case 2:
                if(!$this->has_pasajes) {
                    $this->emit('notify','error','Registre almenos un pasajero');
                    return;
                }
                break;

            default:
                return;
        }
        $this->step++;

    }

}

?>
