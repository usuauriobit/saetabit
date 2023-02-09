<?php
namespace App\Services\Trait\DescuentoService;

use App\Models\Descuento;

trait DescuentosRestantesGetter{
    public function getDescuentosRestantes(){
        $descuentos = collect();
        $this->getInternos()
            ->map(fn($desc) => $descuentos->push($desc));
        $this->getDescuentoIdaVuelta()
            ->map(fn($desc) => $descuentos->push($desc));
        $this->getDescuentoIdaVuelta()
            ->map(fn($desc) => $descuentos->push($desc));
        $this->getDescuentoEdad()
            ->map(fn($desc) => $descuentos->push($desc));
        $this->getDescuentoDiasAnticipacion()
            ->map(fn($desc) => $descuentos->push($desc));
        $this->getDescuentoNormales()
            ->map(fn($desc) => $descuentos->push($desc));
        $this->getDescuentoUltimosCupones()
            ->map(fn($desc) => $descuentos->push($desc));
        // dd($descuentos);
        // dd($descuentos);
        // Consultar con pasajes que ya esten usando el descuento para este vuelo
        // dd($this->pasajesException);
        $descuentos_disponibles_id = [];
        foreach ($descuentos as $descuento) {
            if(is_null($descuento['id'])) continue;

            $cantidad_usado = 0;
            //  Descontar tambien los pasajesException
            foreach ($this->pasajesException as $pasaje) {
                if($pasaje->descuento_id == $descuento->id)
                    $cantidad_usado++;
                $cantidad_usado += $descuento->getCantidadOcupadaByVuelo($this->vuelo_origen);
            }
            if($cantidad_usado < $descuento->nro_maximo)
                $descuentos_disponibles_id []= $descuento->id;
        }

        return Descuento::whereIn('id', $descuentos_disponibles_id)
            ->get()
            ->sort(fn($a, $b) => $a->getMonto($this->tarifa) - $b->getMonto($this->tarifa));
    }
    public function getDescuentoIdaVuelta(){
        // CONSULTAR PRIMERO SI ES POR IDA Y VUELTA
        return Descuento::where('ruta_id', $this->tarifa->ruta_id)
            // ->whereHas('ruta', function($q) use ($origen, $destino) {
            //     return $q->whereHas('tramo', function($q) use ($origen, $destino) {
            //         $q->where('origen_id', $origen->id)
            //         ->where('destino_id', $destino->id);
            //     })
            //     ->whereIsComercial();
            // });
            ->whereTipoPasajeId($this->tarifa->tipo_pasaje_id)
            ->where(function($q){
                $q->whereDate('fecha_expiracion', '>=', $this->vuelo_origen->fecha_hora_vuelo_programado)
                ->orWhere('fecha_expiracion', null);
            })
            ->whereHas('descuento_clasificacion', function($q){
                $q->whereDescripcion('Ida y vuelta');
            })
            ->get();
    }
    public function getDescuentoEdad(){
        return Descuento::where('ruta_id', $this->tarifa->ruta_id)
        ->whereTipoPasajeId($this->tarifa->tipo_pasaje_id)
        ->where(function($q){
            $q->whereDate('fecha_expiracion', '>=', $this->vuelo_origen->fecha_hora_vuelo_programado)
            ->orWhere('fecha_expiracion', null);
        })
        ->where('edad_minima', '<=', $this->persona->edad)
        ->where('edad_maxima', '>=', $this->persona->edad)
        ->whereHas('descuento_clasificacion', function($q){
            $q->whereDescripcion('Rango de edades');
        })
        ->get();
    }
    /*
    * CONSULTAR PRIMERO AL PRIMER NUMERO MENOR AL NUMERO DE DIAS PARA EL DESPEGUE, EJEMPLO:
    * si el viaje es a 9 días, obtener descuento where dias_anticipacion <= dias_para_el_vieja order by dias anticipacion desc
    * iterar sobre estos hasta agotar numero.
    */
    public function getDescuentoDiasAnticipacion(){
        return Descuento::where('ruta_id', $this->tarifa->ruta_id)
            ->whereTipoPasajeId($this->tarifa->tipo_pasaje_id)
            ->where(function($q){
                $q->whereDate('fecha_expiracion', '>=', $this->vuelo_origen->fecha_hora_vuelo_programado)
                ->orWhere('fecha_expiracion', null);
            })
            ->where('dias_anticipacion', '<=', $this->vuelo_origen->dias_restantes)
            ->whereHas('descuento_clasificacion', function($q){
                $q->whereDescripcion('Días de anticipación');
            })
            ->get();
    }
    public function getDescuentoNormales(){
        return Descuento::where('ruta_id', $this->tarifa->ruta_id)
            ->whereTipoPasajeId($this->tarifa->tipo_pasaje_id)
            ->where(function($q){
                $q->whereDate('fecha_expiracion', '>=', $this->vuelo_origen->fecha_hora_vuelo_programado)
                ->orWhere('fecha_expiracion', null);
            })
            ->whereHas('descuento_clasificacion', function($q){
                $q->whereDescripcion('Regular');
            })
            ->get();
    }
    public function getDescuentoUltimosCupones(){
        return Descuento::where('ruta_id', $this->tarifa->ruta_id)
            ->whereTipoPasajeId($this->tarifa->tipo_pasaje_id)
            ->where(function($q){
                $q->whereDate('fecha_expiracion', '>=', $this->vuelo_origen->fecha_hora_vuelo_programado)
                ->orWhere('fecha_expiracion', null);
            })
            ->whereHas('descuento_clasificacion', function($q){
                $q->whereDescripcion('Últimos cupos');
            })
            ->get();
    }
    public function getInternos(){
        return Descuento::where('ruta_id', $this->tarifa->ruta_id)
        ->whereTipoPasajeId($this->tarifa->tipo_pasaje_id)
        ->where(function($q){
            $q->whereDate('fecha_expiracion', '>=', $this->vuelo_origen->fecha_hora_vuelo_programado)
            ->orWhere('fecha_expiracion', null);
        })
        ->whereHas('descuento_clasificacion', function($q){
            $q->whereDescripcion('Interno');
        })
        ->get();
    }
}

?>
