<?php

namespace App\Http\Livewire\Intranet\Comercial\Pasaje\Components;

use App\Models\Pasaje;
use App\Models\PasajeBulto;
use App\Models\Venta;
use App\Models\Vuelo;
use Livewire\Component;

class ItemEquipajes extends Component
{
    public Pasaje $pasaje;
    public Vuelo|null $vuelo;
    public function render(){
        return view('livewire.intranet.comercial.pasaje.components.item-equipajes');
    }
    public function anularPasajeBulto(PasajeBulto $pasajeBulto){
        $pasajeBulto->delete();
        $this->emit('notify', 'success', 'Eliminado correctamente');
        $this->emit('closeModals');
        $this->emit('pasajeChanged');
    }
    public function getCanGenerarVentaProperty(){
        foreach ($this->pasaje->pasaje_bultos as $pasajeBulto) {
            if(!$pasajeBulto->has_venta_detalle && $pasajeBulto->monto_exceso > 0)
                return true;
        }
        return false;
    }
    public function getHasCancelarCajaPendienteProperty(){
        foreach ($this->pasaje->pasaje_bultos as $pasajeBulto) {
            if($pasajeBulto->has_venta_detalle && !$pasajeBulto->is_pagado)
                return true;
        }
        return false;
    }
    public function generarVenta(){
        $venta = Venta::create([
            'clientable_id' => $this->pasaje->pasajero_id,
            'clientable_type' => get_class($this->pasaje->pasajero)
        ]);
        foreach ($this->pasaje->pasaje_bultos_para_generar_detalle_venta as $pasaje_bulto) {

            $descripcion = "{$pasaje_bulto->tipo_bulto_desc}, PAX: {$this->pasaje->nombre_short}.";

            if(!empty($pasaje_bulto->descripcion)){
                $descripcion .= "\nDescripción: {$pasaje_bulto->descripcion}";
            }

            $venta->detalle()->create([
                'cantidad'      => 1,
                'descripcion'   => $descripcion,
                'monto'         => $pasaje_bulto->monto_exceso,
                'documentable_id'   => $pasaje_bulto->id,
                'documentable_type' => get_class($pasaje_bulto),
            ]);
        }
        $this->emit('notify', 'success', 'Generado correctamente');
        $this->emit('closeModals');
        $this->emit('pasajeChanged');
    }
}
