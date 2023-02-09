<?php
namespace App\Services;

use App\Models\Pasaje;
use App\Models\PasajeVuelo;
use App\Models\Vuelo;
use Illuminate\Support\Collection;

class PasajeService {
    public static function getNroAsientosDisponiblesByVuelos(array $vuelos, ?int $restar_pasajes = 0){
        // if(is_null($pasajes)){
        //     $nro_asientos_en_pasajes = 0;
        // }else{
        //     $nro_asientos_en_pasajes = $pasajes->reduce(fn($carry, $pasaje) => $carry += ($pasaje->ocupa_asiento ? 1 : 0), 0);
        // }

        $vuelos_id = array_map(fn($v) => $v['id'], $vuelos);
        $vuelos_db = Vuelo::find($vuelos_id);

        if($vuelos_db->count()>0){
            $menor_cantidad_asientos = $vuelos_db->min('nro_asientos_disponibles');
        }else{
            $menor_cantidad_asientos = collect($vuelos)->min('nro_asientos_disponibles');
        }

        return $menor_cantidad_asientos - $restar_pasajes;
    }

    public static function pasajeroAlreadyHasPasajeInVuelos($persona_id, $vuelos_id){

        return (bool) Pasaje::where('pasajero_id', $persona_id)
                ->whereHas('pasaje_vuelos', function ($q) use ($vuelos_id){
                    return $q->whereIn('vuelo_id', $vuelos_id);
                })
                ->first();
    }

    // public static function anularPasaje(Pasaje $pasaje){
    //     try {
    //         if($pasaje->can_anular){
    //             $pasaje->delete();
    //         }else{
    //             throw "No se puede eliminar este pasaje";
    //         }
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }
}
