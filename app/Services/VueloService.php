<?php
namespace App\Services;

use App\Models\TiempoAvionTramo;
use App\Models\Tramo;
use App\Models\Ubicacion;
use App\Models\Vuelo;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class VueloService {
    public static function getVuelos(Ubicacion $origen, Ubicacion $destino){
        $data = DB::table('vuelos as a')->select('a.*')->distinct()
                ->join('vuelos as b', function ($q){
                    $q->on('a.vuelo_codigo', '=', 'b.vuelo_codigo')
                    ->where('b.stop_number', '>', 'a.stop_number');
                })
                // ->where(function($q) use ($origen, $destino){
                //     $q->where('a.origen_id', $origen->id)
                //         ->orWhere('a.destino_id', $destino->id);
                // })
                // ->where(function($q) use ($origen, $destino){
                //     $q->where('b.origen_id', $origen->id)
                //         ->orWhere('b.destino_id', $destino->id);
                // })
                ->get();
        return $data;
    }

    public static function getTiempoVueloTotal(Vuelo $origen, Vuelo $destino){
        $tiempo = $destino->fecha_hora_aterrizaje_programado->diffInMinutes($origen->fecha_hora_vuelo_programado);
        $hours = $tiempo/60;
        $mins = 0;
        if(is_float($hours)){
            $hours = (int) $hours;
            $mins = $tiempo - ($hours*60);
        }
        return "{$hours} h {$mins} min";
    }

    public static function generarVuelosAgrupados(Vuelo $vuelo, Ubicacion $origen){
        // dd('VUELO A AGRUPAR', $vuelo, $origen);
        if($vuelo->origen_id == $origen->id)
            return [$vuelo];
        return [$vuelo->vuelo_anterior, $vuelo];
    }
    public static function vuelosHasAsientosDisponibles($vuelos, $tarifas_pasajeros): bool {
        $asientos_disponibles = 100;
        foreach ($vuelos as $vuelo) {

            if(is_array($vuelo)){
                $vuelo = Vuelo::find($vuelo['id']);
            }
            if($vuelo->nro_asientos_disponibles < $asientos_disponibles){
                $asientos_disponibles = $vuelo->nro_asientos_disponibles;
            }
        }

        $asientos_solicitados = 0;
        foreach ($tarifas_pasajeros as $item) {
            $asientos_solicitados += ($item['tarifa']['ocupa_asiento'] ? $item['nro'] : 0);
        }

        return $asientos_disponibles >= $asientos_solicitados;
    }

    public static function calcularHoraAtterizaje($hora, $origen, $destino, $with_fecha = false){
        $tramo = Tramo::where('origen_id', $origen->id)
            ->where('destino_id', $destino->id)
            ->first();

        if($with_fecha){
            $hora_despegue = Carbon::createFromFormat('Y-m-d H:i', $hora);
            return $hora_despegue->addMinutes($tramo->minutos_vuelo)->format('Y-m-d H:i:s');
        }else{
            $hora_despegue = Carbon::createFromFormat('H:i', $hora);
            return $hora_despegue->addMinutes($tramo->minutos_vuelo)->format('H:i:s');
        }
    }
    public static function calcularHoraAtterizajeVuelo(Vuelo $vuelo, $fecha_despegue, $with_fecha = false){
        $tiempo_avion_tramo = TiempoAvionTramo::whereHas('tramo', function($q) use ($vuelo){
            $q->where('origen_id', $vuelo->origen_id)
                ->where('destino_id', $vuelo->destino_id);
        })
        ->whereAvionId($vuelo->avion_id)->first();

        if(!$tiempo_avion_tramo){
            throw new Exception("No se ha configurado el tiempo de vuelo del avion");
        }

        if($with_fecha){
            $hora_despegue = Carbon::createFromFormat('Y-m-d H:i', $fecha_despegue);
            // dd($hora_despegue, $fecha_despegue);
            return $hora_despegue->addMinutes($tiempo_avion_tramo->tiempo_vuelo)->format('Y-m-d H:i:s');
        }else{
            $hora_despegue = Carbon::createFromFormat('H:i', $fecha_despegue);
            return $hora_despegue->addMinutes($tiempo_avion_tramo->tiempo_vuelo)->format('H:i');
        }
    }
}
?>
