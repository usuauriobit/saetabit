<?php
namespace App\Models\Traits;

use Carbon\Carbon;

trait PasajeCambioAttributes {

    public function getCambioTitularidadLimitAttribute(){
        return $this->fecha_vuelo_obj
            ->subHours($this->CAMBIO_TITULARIDAD_LIMIT_HOURS[$this->tipo_vuelo_desc]);
    }
    public function getCanCambioTitularidadAttribute(){
        return Carbon::now()->lessThanOrEqualTo($this->cambio_titularidad_limit);
    }
    public function getFechaAbiertaLimitAttribute(){
        return $this->fecha_vuelo_obj
            ->subHours($this->FECHA_ABIERTA_LIMIT_HOURS[$this->tipo_vuelo_desc]);
    }
    public function getCanSetAsFechaAbiertaAttribute(){
        return Carbon::now()->lessThanOrEqualTo($this->fecha_abierta_limit);
    }
    public function getCambioRutaLimitAttribute(){
        return $this->fecha_vuelo_obj
            ->subHours($this->CAMBIO_RUTA_LIMIT_HOURS[$this->tipo_vuelo_desc]);
    }
    public function getCanCambioRutaAttribute(){
        return Carbon::now()->lessThanOrEqualTo($this->cambio_ruta_limit);
    }
    public function getCambioFechaLimitAttribute(){
        return $this->fecha_vuelo_obj
            ->subHours($this->CAMBIO_FECHA_LIMIT_HOURS[$this->tipo_vuelo_desc]);
    }
    public function getCanCambioFechaAttribute(){
        return Carbon::now()->lessThanOrEqualTo($this->cambio_fecha_limit);
    }
}
?>
