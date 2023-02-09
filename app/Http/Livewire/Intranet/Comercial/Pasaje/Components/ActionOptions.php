<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasaje\Components;

use App\Models\Pasaje;
use App\Models\PasajeLiberacionHistorial;
use App\Models\Venta;
use App\Models\Vuelo;
use App\Services\TasaCambioService;
use Livewire\Component;

class ActionOptions extends Component
{
    public Pasaje $pasaje;
    public Vuelo|null $vuelo;
    public function render() {
        return view('livewire.intranet.comercial.pasaje.components.action-options');
    }

    public function anularPasaje(){
        if($this->pasaje->can_anular){
            $this->pasaje->delete();
        }
        $this->emit('notify','success', 'Se anuló correctamente 😃.');
        $this->emit('pasajeChanged');
    }
    public function setCheckin(){
        $this->pasaje->update(['checkin_date_time' => date('Y-m-d H:i:s')]);
        $this->emit('pasajeChanged');
        $this->emit('notify', 'success', 'Registrado correctamente 😃.');
    }
    public function deleteCheckin(){
        $this->pasaje->update(['checkin_date_time' => null]);
        $this->emit('pasajeChanged');
        $this->emit('notify', 'success', 'Registrado correctamente.');
    }
    public function deleteBulto() {
        if(!$this->pasaje->pasaje_bulto->is_pagado){
            optional(optional(optional($this->pasaje)->pasaje_bulto->venta_detalle)->venta)->delete();
            $this->pasaje->pasaje_bulto->delete();
            $this->emit('notify', 'success', 'Se eliminó correctamente.');
            $this->emit('pasajeChanged');
        }else{
            return $this->emit('notify', 'error', 'No se puede eliminar, ya hay una transacción en caja.');
        }
    }

    public function liberarAsiento (){
        $this->pasaje->update(['is_asiento_libre' => true]);
        $this->emit('pasajeChanged');
        $this->emit('notify', 'success', 'Ahora el asiento está disponible para otro pasajero.');
    }
    public function quitarLiberarAsiento(){
        $canLiberarAsiento = true;
        foreach ($this->pasaje->vuelos as $vuelo) {
            if(!$vuelo->has_asientos_disponibles){
                $canLiberarAsiento = false;
                break;
            }
        }
        if(!$canLiberarAsiento){
            $this->emit('notify', 'error', 'Ya no hay asientos disponibles para este vuelo o vuelos en ruta.');
            return;
        }
        $this->pasaje->update(['is_asiento_libre' => false]);
        $this->emit('pasajeChanged');
        $this->emit('notify', 'success', 'Registrado correctamente 😃.');
    }
}
