<?php
namespace App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait;

trait UIActions{
    public $step = 1;
    public $rutaOpenned = false;

    public function backStep(){
        $this->step--;
    }
    public function nextStep(){
        if($this->step == 1){
            if(empty($this->vuelos_selected['ida'])) {
                $this->emit('notify','error','Seleccione un vuelo de ida');
                return;
            }
            if($this->form['type'] == 'ida_vuelta' && empty($this->vuelos_selected['vuelta'])) {
                $this->emit('notify','error','Seleccione un vuelo de vuelta');
                return;
            }
        }
        if($this->step == 2){
            if(empty($this->pasajes)) {
                $this->emit('notify','error','Registre almenos un pasajero');
                return;
            }
        }
        $this->step++;
    }
    public function toogleRutaOpenned(){
        $this->rutaOpenned = !$this->rutaOpenned;
    }
}
?>
