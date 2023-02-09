<?php
namespace App\Http\Livewire\LandingPage\RegistrarPasajerosTrait;

use App\Models\Vuelo;
use App\Services\TarifaService;
use App\Services\VueloService;

trait ValidateStart{
    private function _validarQs(){
        $startOk = false;
        $this->errorMsg = 'Ha ocurrido un error';
        if(
            $this->qs_vuelos_ida &&
            $this->qs_tarifas_ida
        ){
            $startOk = true;
        }
        if(
            $this->qs_vuelos_vuelta &&
            !$this->qs_tarifas_vuelta
        ){
            $startOk = false;
            $this->errorMsg = 'Ha ocurrido un error interno.';
        }

        $this->startOk = $startOk;
    }
    private function _validarTarifas(){
        $this->tarifas_ida = $this->vuelos_ida
            ? TarifaService::calcularTarifas($this->vuelos_ida->toArray(), $this->qs_tarifas_ida)
            : [];

        if($this->is_ida_vuelta){
            $this->tarifas_vuelta = $this->vuelos_vuelta
                ? TarifaService::calcularTarifas($this->vuelos_vuelta->toArray(), $this->qs_tarifas_vuelta)
                : [];
        }
    }
    private function _validarVuelos(){
        $this->vuelos_ida = Vuelo::whereIn('codigo',$this->qs_vuelos_ida)->get();

        if(!$this->vuelos_ida){
            $this->startOk = false;
            $this->errorMsg = 'Error interno [VINF]';
        }

        if($this->is_ida_vuelta){
            $this->vuelos_vuelta    = Vuelo::whereIn('codigo',$this->qs_vuelos_vuelta)->get();
            if(!$this->vuelos_vuelta){
                $this->startOk = false;
                $this->errorMsg = 'Error interno [VVNF]';
            }
        }

    }
    private function _validarAsientosDisponibles(){
        foreach ($this->type as $type) {
            $has_asientos_disponibles = VueloService::vuelosHasAsientosDisponibles($this->{'vuelos_'.$type}, $this->{'tarifas_'.$type});

            if(!$has_asientos_disponibles){
                $this->startOk = false;
                $this->errorMsg = 'Ya no hay asientos disponibles para el vuelo de '.$type.' con la cantidad de pasajeros seleccionados';
                return false;
            }
        }
        return true;
    }
}
?>
