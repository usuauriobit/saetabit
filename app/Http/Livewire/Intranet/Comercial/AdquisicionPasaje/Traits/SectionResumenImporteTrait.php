<?php
namespace App\Http\Livewire\Intranet\Comercial\AdquisicionPasaje\Traits;

use App\Models\Cliente;
use App\Models\Descuento;
use App\Models\Persona;
use App\Services\DescuentoService;

trait SectionResumenImporteTrait {
    public function getIsWithVentaProperty(){
        return !(optional($this->tipo_vuelo)->is_charter);
    }
    // IMPORTE SIN DESCUENTO
    public function getImporteSinDescuentoProperty(){
        return $this->pasaje_importe_sin_descuento;
    }
    public function getMontoDescuentoGeneralProperty(){
        return $this->descuento_general
            ? DescuentoService::calcularValorDescuento($this->pasaje_importe_final, $this->descuento_general)
            : 0;
    }
    public function getHasDescuentoGeneralProperty(){
        return $this->monto_descuento_general > 0;
    }
    // MONTO DESCUENTO
    public function getMontoDescuentoTotalProperty(){
        return $this->importe_sin_descuento - $this->importe_final;
    }
    // IMPORTE FINAL
    public function getImporteFinalProperty(){
        $importe_final = 0;
        $importe_final += $this->pasaje_importe_final;
        $importe_final -= $this->monto_descuento_general;
        return $importe_final;
    }


    // PASAJES - IMPORTE SIN DESCUENTO
    public function getPasajeImporteSinDescuentoProperty(){
        return $this->_calcularPasajeroImporteByCampo('importe');
    }
    // PASAJES - IMPORTE FINAL
    public function getPasajeImporteFinalProperty(){
        return $this->_calcularPasajeroImporteByCampo('importe_final_calc');
    }
    private function _calcularPasajeroImporteByCampo($campo){
        return $this->all_pasajes_plane->reduce(fn($carry, $pasaje) => $carry + $pasaje[$campo]);;
    }
    // PASAJES - MONTO DESCUENTO
    public function getPasajeMontoDescuentoProperty(){
        return $this->pasaje_importe_sin_descuento - $this->pasaje_importe_final;
    }

    public function setCliente($cliente_id, $type){
        $type == 'persona_juridica'
            ? $this->comprador = Cliente::find($cliente_id)
            : $this->comprador = Persona::find($cliente_id);
    }
    public function getHasDescuentoProperty(){
        return (bool) $this->monto_descuento_total > 0;
    }
    public function getHasPasajesDescuentoProperty(){
        return (bool) $this->pasaje_monto_descuento > 0;
    }
    public function getCanHaveDescuentoGeneralProperty(){
        if($this->pasaje_importe_final == 0 || !$this->descuentos_vuelo){
            $this->descuento_general = null;
            return false;
        }
        return true;
    }
    public function quitarDescuentoGeneral(){
        $this->descuento_general = null;
    }
    public function asignarDescuentoGeneral(Descuento $descuento){
        $this->descuento_general = $descuento;
    }
    public function removeCliente(){
        $this->comprador = null;
    }
}
?>
