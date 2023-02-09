<?php

namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Components;

use App\Models\Vuelo;
use App\Services\DescuentoService;
use Livewire\Component;

class ItemPasajeResumen extends Component {
    public $nro;
    public $type;
    public $isLibre;
    public $pasaje;
    public $pasajesAll;
    public Vuelo $vueloOrigen;

    // public $descuentos_pasaje;

    public function mount(
        $nro,
        $type,
        $isLibre,
        $pasaje,
        $pasajesAll,
        $vueloOrigen
    ){
        $this->nro      = $nro;
        $this->type     = $type;
        $this->isLibre  = $isLibre;
        $this->pasaje   = $pasaje;
        $this->pasajesAll   = $pasajesAll;
        $this->vueloOrigen  = $vueloOrigen;
    }

    public function render() {
        // $this->descuentos_pasaje = $this->getDescuentosPasaje();
        return view('livewire.intranet.comercial.adquisicion-pasaje.components.item-pasaje-resumen');
    }
    public function getDescuentosPasajeProperty(){
        $descuento_instance = new DescuentoService(
            vuelo_origen: $this->vueloOrigen,
            tarifa      : $this->pasaje->tarifa,
            is_ida_vuelta: false,
            tipoPasaje  : $this->pasaje->tipo_pasaje,
            persona     : $this->pasaje->pasajero,
            pasajesException: $this->pasajesAll
        );
        $descuentos = $descuento_instance->getDescuentosRestantes();
        // dd($descuentos);
        return $descuentos;
    }

    public function setDescuento($pasaje_temporal_id, $descuento_id){
        // dd('sdasd');
        $this->emit('asignarDescuentoPasaje', $pasaje_temporal_id, $descuento_id);
    }
    public function quitarDescuentoPasaje($temporal_id){
        $this->emit('quitarDescuentoPasaje', $temporal_id);
    }
}
