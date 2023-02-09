<?php

namespace App\Services;

use App\Models\CajaMovimiento;

class AperturaCierreService
{
    static function totalTipoPago($tipo_pago_id, $apertura_cierre_id)
    {
        return self::movimientosTipoPago($tipo_pago_id, $apertura_cierre_id)->sum('total');
    }

    static function movimientosTipoPago($tipo_pago_id, $apertura_cierre_id)
    {
        return CajaMovimiento::whereAperturaCierreId($apertura_cierre_id)
                        ->whereTipoPagoId($tipo_pago_id)
                        ->get();
    }

    static function movimientosExtornados($apertura_cierre_id)
    {
        return CajaMovimiento::onlyTrashed()
                        ->whereAperturaCierreId($apertura_cierre_id)
                        ->get();
    }

    static function totalMovimientosExtornados($apertura_cierre_id)
    {
        return self::movimientosExtornados($apertura_cierre_id)->sum('total');
    }
}
