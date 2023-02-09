<?php

namespace App\Services;

use App\Models\Tarifa;
use App\Models\TipoPasaje;

class TarifaService{
    public static function calcularTarifas(Array $vuelos, $nro_pasajes){
        $tarifas = [];
        foreach ($nro_pasajes as $nro_pasaje) {
            if($nro_pasaje['nro'] <= 0) continue;
            $tipo_pasaje_db = TipoPasaje::whereDescripcion($nro_pasaje['descripcion'])->first();

            $tarifa = Tarifa::where('tipo_pasaje_id', $tipo_pasaje_db->id)
                ->whereHas('ruta', function($q) use ($vuelos) {
                    $q->whereHas('tipo_vuelo', function($q) {
                        $q->whereIsComercial();
                    })
                    ->whereHas('tramo', function($q) use ($vuelos){
                        $q->where('origen_id', $vuelos[0]['origen_id'])
                            ->where('destino_id', end($vuelos)['destino_id']);
                    });
                })
                ->first();
            $tarifas[] = array_merge($nro_pasaje, [
                'tarifa' => $tarifa,
                'total' => $nro_pasaje['nro']*$tarifa['precio']
            ]);
        }
        return $tarifas;
    }
}
