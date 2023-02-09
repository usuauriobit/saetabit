<?php

namespace App\Services;

use App\Models\TasaCambioValor;

class TasaCambioService {
    public Float $tasa_cambio;
    public TasaCambioValor|null $tasa_cambio_valor;

    public function __construct() {
        $this->tasa_cambio_valor = TasaCambioValor::latest('fecha')->first();
        $this->tasa_cambio = optional($this->tasa_cambio_valor)->valor_venta ?? 3.90;
    }

    public function getMontoSoles(Float|int|string $monto_dolar, Float|string|null $tasa_cambio = null ):Float {
        $tc = !is_null($tasa_cambio) ? $tasa_cambio : $this->tasa_cambio;
        return (float) (( (float) $monto_dolar) * $tc);
    }

    public function getMontoDolares(Float|int|string $monto_soles, Float|string|null $tasa_cambio = null):Float {
        $tc = !is_null($tasa_cambio) ? $tasa_cambio : $this->tasa_cambio;
        return (float) (( (float) $monto_soles) / $tc);
    }
}
