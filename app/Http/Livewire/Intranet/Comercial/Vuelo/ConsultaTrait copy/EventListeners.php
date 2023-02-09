<?php
namespace App\Http\Livewire\Intranet\Comercial\Vuelo\ConsultaTrait;

use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Ruta;

trait EventListeners{


    public function setUbicacion($type, $ubicacion_id){
        if($type == 'destino')
            $this->form['destino_id'] = $ubicacion_id;
        if($type == 'origen')
            $this->form['origen_id'] = $ubicacion_id;
    }
    public function setRuta(Ruta $ruta){
        $this->form['destino_id'] = optional($ruta->tramo)->destino_id;
        $this->form['origen_id'] = optional($ruta->tramo)->origen_id;
    }
    public function addPasaje($data){
        $this->pasajes[] = array_merge($data, ['temporal_id' => uniqid()]);
    }
    public function setCliente($cliente_id, $type){
        if($type == 'persona_juridica'){
            $this->cliente = Cliente::find($cliente_id);
        }else{
            $this->cliente = Persona::find($cliente_id);
        }
    }
}
