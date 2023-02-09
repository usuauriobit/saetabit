<?php

namespace App\Http\Livewire\Intranet\TrackingCarga\Components;

use App\Models\GuiaDespacho;
use App\Models\GuiaDespachoStep;
use Livewire\Component;

class TrackSection extends Component
{
    public GuiaDespacho $guiaDespacho;
    public $register_type = '';
    public $onlyShow = false; // Para casos como landing page, donde solo se muestra el estado de la guia
    public $showAlerts = true;
    public $listeners = [
        'vuelosSelected' => 'setVuelos',
        'oficinaSelected' => 'setOficina'
    ];
    public function mount(){
        if($this->onlyShow) $this->showAlerts = false;

        if(!$this->guiaDespacho->can_set_step){
            $this->onlyShow = true;
        }
    }
    public function render()
    {
        return view('livewire.intranet.tracking-carga.components.track-section');
    }
    public function setRegisterType($type){
        $this->register_type = $type;
    }
    public function setVuelos($vuelos){
        $v = $vuelos;
        $es_igual = $this->esIgualAlUltimoMovimiento(array_pop($v));

        if($es_igual){
            $this->emit('notify', 'error', 'El lugar seleccionado ya figura en el último estado de seguimiento');
            return;
        }
        foreach ($vuelos as $vuelo_id) {
            GuiaDespachoStep::create([
                'guia_despacho_id' => $this->guiaDespacho->id,
                'stepable_id'       => $vuelo_id,
                'stepable_type'     => 'App\Models\Vuelo',
                'fecha'             => date('Y-m-d H:i:s'),
            ]);
        }
        $this->return();
    }
    public function setOficina($oficina_id){
        $es_igual = $this->esIgualAlUltimoMovimiento($oficina_id);
        if($es_igual){
            $this->emit('notify', 'error', 'El lugar seleccionado ya figura en el último estado de seguimiento');
            return;
        }
        GuiaDespachoStep::create([
            'guia_despacho_id' => $this->guiaDespacho->id,
            'stepable_id'       => $oficina_id,
            'stepable_type'     => 'App\Models\Oficina',
            'fecha'             => date('Y-m-d H:i:s'),
        ]);
        $this->return();
    }
    public function return(){
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
        $this->guiaDespacho->refresh();
        $this->register_type = '';
        $this->emit('closeModals');
    }
    public function esIgualAlUltimoMovimiento($stepable_id){
        $ultimo_movimiento = $this->guiaDespacho->guia_despacho_steps->last();
        if($ultimo_movimiento){
            return $ultimo_movimiento->stepable_id === $stepable_id;
        }
        return false;
    }
    public function registrarEntrega(){
        $this->guiaDespacho->update([
            'fecha_entrega' => date('Y-m-d H:i:s')
        ]);
        $this->return();
    }
}
