<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Vuelo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'vuelo_ruta_id',
        'tipo_vuelo_id',
        'avion_id',
        'origen_id',
        'destino_id',
        'hora_despegue',
        'hora_aterrizaje',
        'fecha_hora_vuelo_programado',
        'fecha_hora_aterrizaje_programado',
        'nro_asientos_ofertados',
        'stop_number',
        'is_closed',
        'user_confirmed_id',
        'fecha_confirmed',
        'vuelo_massive_id',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    protected $dates = [
        'hora_despegue',
        'hora_aterrizaje',
        'fecha_hora_vuelo_programado',
        'fecha_hora_aterrizaje_programado',
    ];

    protected $casts = [
        'fecha_hora_vuelo_programado' => 'datetime',
        'fecha_hora_aterrizaje_programado' => 'datetime',
        // 'hora_aterrizaje' => 'datetime:H:i',
        // 'hora_despegue' => 'datetime:H:i',
    ];

    // public function getAllPasajesAttribute(){
    //     // OBTENER PASAJES QUE VIENEN DE VUELOS ANTERIORES Y CONTINUAN EN ESTE VUELO
    //     $pasajes = $this->pasajes;
    //     // OBTENER VUELOS ANTERIORES
    //     $vuelo_anterior = $this->vuelo_anterior;
    //     if($vuelo_anterior){
    //         // Obtener los pasajes y revisar si tambien tienen este vuelo
    //         foreach ($vuelo_anterior->pasajes as $pasaje) {
    //             if($pasaje->hasVuelo($this->id) && !$pasajes->contains('id', $pasaje->id)){
    //                 $pasajes->add($pasaje);
    //             }
    //         }
    //     }

    //     // // GET PASAJES QUE PARTEN DESDE ESTE VUELO
    //     // $pasajes['current_vuelo'] = $this->pasajes;
    //     return $pasajes;
    // }
    public function getCanEditarMonitoreoAttribute(){
        return $this->dias_disponibles_para_editar_monitoreo > 0;
    }
    public function getDiasDisponiblesParaEditarMonitoreoAttribute(){
        return $this->hora_despegue->format('d') - Carbon::now()->format('d') + 2;
    }

    public function getRutaSimpleAttribute(){
        return optional($this->origen)->codigo_default."-".optional($this->destino)->codigo_default;
    }
    public function getHorarioAttribute(){
        return optional($this->fecha_hora_vuelo_programado)->format('g:i a')
            ."-"
            .optional($this->fecha_hora_aterrizaje_programado)->format('g:i a');
    }

    public function getCodigoCargasAttribute(){
        return "G".$this->codigo;
    }

    public function getIsOrigenAttribute(){
        return (bool) $this->stop_number == 0;
    }
    public function getIsDestinoAttribute(){
        return (bool) !$this->fecha_hora_aterrizaje_programado && $this->fecha_hora_aterrizaje_programado;
    }
    public function getIsEscalaAttribute(){
        return (bool) $this->fecha_hora_aterrizaje_programado && $this->fecha_hora_aterrizaje_programado;
    }
    public function getNroEscalasAttribute(){
        return Vuelo::whereVueloRutaId($this->vuelo_ruta_id)->where('stop_number', '>', ($this->stop_number))->count();
    }
    public function getVueloAnteriorAttribute(){
        return Vuelo::whereVueloRutaId($this->vuelo_ruta_id)
        ->where('stop_number', '=', ($this->stop_number - 1))
        ->first();
    }
    public function getVueloSiguienteAttribute(){
        return Vuelo::whereVueloRutaId($this->vuelo_ruta_id)
        ->where('stop_number', '=', ($this->stop_number + 1))
        ->first();
    }
    // public function getDestinoAttribute(){
    //     return Vuelo::whereVueloCodigo($this->vuelo_codigo)->where('stop_number', ($this->stop_number + 1))->first();
    // }
    public function  getHoraDespegueDiffAttribute(){
        if( $this->fecha_hora_vuelo_programado && $this->hora_despegue)
            return $this->fecha_hora_vuelo_programado->diffInMinutes($this->hora_despegue);
        return 0;
    }
    public function  getHoraAterrizajeDiffAttribute(){
        if( $this->fecha_hora_aterrizaje_programado && $this->hora_aterrizaje)
            return $this->fecha_hora_aterrizaje_programado->diffInMinutes($this->hora_aterrizaje);
        return 0;
    }
    public function getMinVueloAttribute(){
        if( $this->fecha_hora_aterrizaje_programado && $this->fecha_hora_vuelo_programado)
            return $this->fecha_hora_aterrizaje_programado->diffInMinutes($this->fecha_hora_vuelo_programado);
        return 0;
    }
    public function getMinVueloRealAttribute(){
        if( $this->hora_aterrizaje && $this->hora_despegue)
            return $this->hora_aterrizaje->diffInMinutes($this->hora_despegue);
        return 0;
    }
    public function getTiempoVueloAttribute(){
        $hours = $this->min_vuelo/60;
        $mins = 0;
        if(is_float($hours)){
            $hours = (int) $hours;
            $mins = $this->min_vuelo - ($hours*60);
        }
        return "{$hours} h {$mins} min";
    }
    public function getTiempoVueloRealAttribute(){
        $hours = $this->min_vuelo_real/60;
        $mins = 0;
        if(is_float($hours)){
            $hours = (int) $hours;
            $mins = $this->min_vuelo_real - ($hours*60);
        }
        return "{$hours} h {$mins} min";
    }
    public function getDiferenciaTiempoVueloMinAttribute(){
        return $this->min_vuelo - $this->min_vuelo_real;
    }

    public function getHasAsientosDisponiblesAttribute(){
        return $this->nro_asientos_disponibles > 0;
    }
    public function getNroAsientosDisponiblesAttribute(){
        return $this->nro_asientos_ofertados - $this->nro_asientos_ocupados;
    }
    public function getNroAsientosOcupadosAttribute(){
        return $this->pasajes()->whereHas('tarifa', function ($q){
            $q->where('ocupa_asiento', true);
        })
        ->where('is_asiento_libre', false)
        ->count();
    }
    public function getDiasRestantesAttribute(){
        return Carbon::now()->diffInDays($this->fecha_hora_vuelo_programado);
    }

    public function getPilotoAttribute(){
        return $this->tripulacion()->whereHas('tipo_tripulacion', function($q){return $q->whereDescripcion('Piloto');})->first();
    }
    public function getCopilotoAttribute(){
        return $this->tripulacion()->whereHas('tipo_tripulacion', function($q){return $q->whereDescripcion('Copiloto');})->first();
    }
    public function getPilotoVueloAttribute(){
        return $this->tripulacion_vuelo()
                ->whereHas('tripulacion', function ($q){
                    return $q->whereHas('tipo_tripulacion', function($q){
                        return $q->whereDescripcion('Piloto');
                    });
                })->first();
    }
    public function getCopilotoVueloAttribute(){
        return $this->tripulacion_vuelo()
                ->whereHas('tripulacion', function ($q){
                    return $q->whereHas('tipo_tripulacion', function($q){return $q->whereDescripcion('Copiloto');});
                })->first();
    }
    public function getRutaDescripcionAttribute(){
        return $this->origen->ubigeo->distrito . ' - ' . $this->destino->ubigeo->distrito;
    }

    public function getHasMonitoreoAttribute(){
        return !is_null($this->hora_despegue) && !is_null($this->hora_aterrizaje);
    }
    public function getHasPasajesSinPagarAttribute(){
        foreach ($this->pasajes as $pasaje) {
            if(!$pasaje->is_pagado)
                return true;
        }
    }
    public function getCanCerrarVueloAttribute(){
        // DEBE HABER REGISTRO DE MONITOREO DE DESPEGUE Y ATERRIZAJE
        // DEBE HABER REGISTRO DE AVIÓN
        // DEBE HABER REGISTRO DE TRIPULACIÓN
        // NO DEBE HABER PASAJES SIN PAGAR
        return $this->avion
            && !$this->is_closed
            // && $this->has_monitoreo
            && $this->tripulacion_vuelo->count() > 0
            && !$this->has_pasajes_sin_pagar;
    }
    public function getIsCharterAttribute(){
        return optional(optional($this->tipo_vuelo)->categoria_vuelo)->descripcion === 'Chárter';
    }

    public function getPasajesAereosCantidadAttribute(){
        $total = 0;
        foreach ($this->vuelo_pasajes as $vuelo_pasaje) {
            $total += $vuelo_pasaje->pasaje->isFromVueloAnterior($this->vuelo_anterior->id ?? null) ? 0 : 1;
        }
        return $total;
    }
    public function getCargaCorreoCantidadAttribute(){
        $total = 0;
        foreach ($this->guias_despacho_vuelo as $guia_despacho_vuelo) {
            $total += $guia_despacho_vuelo->isVueloInicial($this->id) ? 1 : 0;
        }
        return $total;
    }
    public function getExcesoEquipajeCantidadAttribute(){
        $sum = 0;
        foreach ($this->pasajes as $pasaje)
            $sum += $pasaje->equipajes->where('peso_excedido', '>', 0)->count();
        return $sum;
    }
    public function getCambioTitularFechaCantidadAttribute(){
        $sum = 0;
        foreach ($this->pasajes as $pasaje)
            $sum += $pasaje->pasaje_cambios->count();

        return $sum;
    }

    public function getPasajesAereosContadoAttribute(){
        $total = 0;
        foreach ($this->vuelo_pasajes as $vuelo_pasaje) {
            $total += $vuelo_pasaje->pasaje->isFromVueloAnterior($this->vuelo_anterior->id ?? null) ? 0 : $vuelo_pasaje->total_contado;
        }
        return $total;
    }
    public function getPasajesAereosCreditoAttribute(){
        $total = 0;
        foreach ($this->vuelo_pasajes as $vuelo_pasaje) {
            $total += $vuelo_pasaje->pasaje->isFromVueloAnterior($this->vuelo_anterior->id ?? null) ? 0 : $vuelo_pasaje->total_credito;
        }
        return $total;
    }
    public function getCargaCorreoContadoAttribute(){
        $total = 0;
        foreach ($this->guias_despacho_vuelo as $guia_despacho_vuelo)
            $total += $guia_despacho_vuelo->totalContado($this->id);

        return $total;
    }
    public function getCargaCorreoCreditoAttribute(){
        $total = 0;
        foreach ($this->guias_despacho_vuelo as $guia_despacho_vuelo)
            $total += $guia_despacho_vuelo->totalCredito($this->id);

        return $total;
    }
    public function getExcesoEquipajeContadoAttribute(){
        $total = 0;
        foreach ($this->pasajes as $pasaje)
            $total += $pasaje->equipajes->where('peso_excedido', '>', 0) ? $pasaje->equipajes->sum('total_contado') : 0;
        return $total;
    }
    public function getExcesoEquipajeCreditoAttribute(){
        $total = 0;
        foreach ($this->pasajes as $pasaje)
            $total += $pasaje->equipajes->where('peso_excedido', '>', 0) ? $pasaje->equipajes->sum('total_credito') : 0;
        return $total;
    }
    public function getCambioTitularFechaContadoAttribute(){
        $total = 0;
        foreach ($this->pasajes as $pasaje)
            $total += $pasaje->pasaje_cambios->sum('total_contado');

        return $total;
    }
    public function getCambioTitularFechaCreditoAttribute(){
        $total = 0;
        foreach ($this->pasajes as $pasaje)
            $total += $pasaje->pasaje_cambios->sum('total_credito');

        return $total;
    }

    public function getPasajesAereosTotalAttribute(){
        return
        // $this->pasajes_aereos_cantidad +
        $this->pasajes_aereos_contado +
        $this->pasajes_aereos_credito;
    }
    public function getCargaCorreoTotalAttribute(){
        return
        // $this->carga_correo_cantidad +
        $this->carga_correo_contado +
        $this->carga_correo_credito;
    }
    public function getExcesoEquipajeTotalAttribute(){
        return
        // $this->exceso_equipaje_cantidad +
        $this->exceso_equipaje_contado +
        $this->exceso_equipaje_credito;
    }
    public function getCambioTitularFechaTotalAttribute(){
        return
        // $this->cambio_titular_fecha_cantidad +
        $this->cambio_titular_fecha_contado +
        $this->cambio_titular_fecha_credito;
    }
    public function getTotalContadoAttribute(){
        return $this->pasajes_aereos_contado +
        $this->carga_correo_contado +
        $this->exceso_equipaje_contado +
        $this->cambio_titular_fecha_contado;
    }
    public function getTotalCreditoAttribute(){
        return $this->pasajes_aereos_credito +
        $this->carga_correo_credito +
        $this->exceso_equipaje_credito +
        $this->cambio_titular_fecha_credito;
    }
    public function getTotalTotalAttribute(){
        return $this->pasajes_aereos_total +
        $this->carga_correo_total +
        $this->exceso_equipaje_total +
        $this->cambio_titular_fecha_total;
    }

    public function getComprobantesAttribute(){
        $comprobantes = collect();
        foreach ($this->pasajes as $pasaje) {
            foreach($pasaje->comprobantes as $comprobante){
                if(!isset($comprobantes[$comprobante->title])){
                    $comprobantes[$comprobante->title] = collect();
                }
                $comprobantes[$comprobante->title] = $comprobantes[$comprobante->title]->merge($comprobante->detalle);
            }
        }
        // TODO: Guias despacho
        $comprobantes['Cargas'] = collect();
        foreach ($this->guias_despacho_vuelo as $guia_despacho_vuelo) {
            $comprobantes['Cargas'][] = optional($guia_despacho_vuelo->guia_despacho->comprobante)->ultima_respuesta;
        }
        return $comprobantes;
    }

    // public function getPasajesAttribute(){
    //     return Pasaje::whereHas('vuelo_ruta', function ($q){
    //         $q->whereId($this->vuelo_ruta_id);
    //     })->get()
    //     ;
    // }
    public function getCanDeleteAttribute(){
        return
        $this->guias_despacho_vuelo->count() === 0 &&
        $this->vuelo_pasajes->count() === 0 &&
        $this->pasajes->count() === 0 &&
        $this->tripulacion->count() === 0 &&
        $this->pasaje_cambio_vuelos->count() === 0 &&
        $this->incidencias_avion->count() === 0 &&
        $this->incidencias_tripulacion->count() === 0 &&
        $this->incidencias_escala->count() === 0 &&
        $this->incidencias_fecha->count() === 0;
    }

    public function getPasajesPreliminaresAttribute(){
        $pasajeros_preliminares = [];
        foreach ($this->pasajes as $pasaje) {
            if($pasaje->is_pagado){
                $pasajeros_preliminares[] = $pasaje;
            }
        }
        return $pasajeros_preliminares;
    }

    public function vuelo_ruta()            : BelongsTo { return $this->belongsTo(VueloRuta::class); }
    public function guias_despacho_vuelo()  { return $this->morphMany(GuiaDespachoStep::class, 'stepable'); }
    // public function guias_despacho()        : BelongsToMany { return $this->belongsToMany(GuiaDespacho::class, GuiaDespachoStep::class ); }

    public function vuelo_escala()          : BelongsTo { return $this->belongsTo(Vuelo::class, 'vuelo_escala_id', 'id'); }
    public function escalas()               : HasOne { return $this->hasOne(Vuelo::class, 'vuelo_escala_id', 'id'); }
    public function vuelo_pasajes()         : HasMany { return $this->hasMany(PasajeVuelo::class); }
    public function vuelo_pasajes_checkin() : HasMany { return $this->hasMany(PasajeVuelo::class); }

    public function pasajes()               : BelongsToMany { return $this->belongsToMany(Pasaje::class, PasajeVuelo::class)->whereNull('pasaje_vuelos.deleted_at')->withTimestamps(); }
    public function pasajes_con_checkin()   : BelongsToMany {
        return $this->belongsToMany(Pasaje::class, PasajeVuelo::class)
        ->whereNotNull('pasajes.checkin_date_time')
        ->whereNull('pasaje_vuelos.deleted_at')
        ->withTimestamps();
    }
    // public function pasajes_checkin()       : BelongsToMany { return $this->belongsToMany(Pasaje::class, PasajeVuelo::class)->whereNull('pasaje_vuelos.deleted_at')->withTimestamps(); }
    public function tripulacion_vuelo()     : HasMany { return $this->hasMany(TripulacionVuelo::class); }
    public function tripulacion()           : BelongsToMany { return $this->belongsToMany(Tripulacion::class, TripulacionVuelo::class)->whereNull('tripulacion_vuelos.deleted_at')->withTimestamps();; }

    public function pasaje_cambio_vuelos()  : HasMany { return $this->hasMany(PasajeCambioVuelo::class); }

    public function vuelo_massive()     : BelongsTo { return $this->belongsTo(VueloMassive::class); }
    public function tipo_vuelo()        : BelongsTo { return $this->belongsTo(TipoVuelo::class); }
    public function avion()             : BelongsTo { return $this->belongsTo(Avion::class); }
    public function origen()            : BelongsTo { return $this->belongsTo(Ubicacion::class, 'origen_id', 'id'); }
    public function destino()           : BelongsTo { return $this->belongsTo(Ubicacion::class, 'destino_id', 'id'); }
    public function user_confirmed()    : BelongsTo { return $this->belongsTo(User::class, 'user_confirmed_id', 'id'); }

    public function incidencias_avion(): HasMany { return $this->hasMany(IncidenciaAvion::class); }
    public function incidencias_tripulacion(): HasMany { return $this->hasMany(IncidenciaTripulacion::class); }
    public function incidencias_escala(): HasMany { return $this->hasMany(IncidenciaEscala::class, 'vuelo_primario_id', 'id'); }
    public function incidencias_fecha(): HasMany { return $this->hasMany(IncidenciaFecha::class, 'vuelo_id', 'id'); }

    public function scopeWhereIsCharterComercial($q){
        return $q;
    }
    public function scopeWhereIsCharterEmergenciaMedica($q){
        return $q;
    }
    public function scopeWhereIsCharterConvenio($q){
        return $q;
    }
    public function scopeWhereIsComercial($q){
        return $q->whereHas('tipo_vuelo', function($q){
            $q->whereDescripcion('Comercial');
        });
    }

    // public function scopeWhereIsOrigen($q){
    //     return $q->whereStopNumber(0);
    // }
    // public function scopeWhereIsNotDestino($q){
    //     return $q->whereNotNull('fecha_hora_vuelo_programado');
    // }

    public function scopeWhereCategoriaId($q, $categoria_id){
        return $q->whereHas('tipo_vuelo', function($q) use ($categoria_id) {
            return $q->where('categoria_vuelo_id', $categoria_id);
        });
    }

    public function scopeFilterSearch(
            $q,
            $search,
            $categoria_id = null,
            // $from = null,
            // $to = null,
            // $fecha = null,
            $desde = null,
            $hasta = null,
            $origen = null,
            $destino=null
    ){
		$search = '%'.$search .'%';
        return
            $q->when($categoria_id, function($q) use ($categoria_id){
                return $q->whereCategoriaId($categoria_id);
            })
            // ->when(
            //     $fecha ||
            //     $from ||
            //     $to ||
            //     $origen ||
            //     $destino,
            //     function($q) use ($from, $to, $origen, $destino, $fecha){
            //         $q->where(function($q) use ($fecha, $from, $to, $origen, $destino){
            //             $q
                        // ->when(isset($origen), function($q) use ($origen){
                        //     return $q->where('origen_id', $origen);
                        // })
                        // ->when(isset($destino), function($q) use ($destino){
                        //     return $q->where('destino_id', $destino);
                        // })
                        // ->when(isset($from), function($q) use ($from,$to){
                        //     if(!isset($to)){
                        //         return $q->whereDate('fecha_hora_vuelo_programado', $from);
                        //     }else{
                        //         return $q->whereDate('fecha_hora_vuelo_programado', '>=', $from);
                        //     }
                        // })
                        // ->when(isset($to), function($q) use ($to){
                        //     return $q->whereDate('fecha_hora_vuelo_programado', '<=', $to);
                        // })
                        // ->when(isset($fecha), function($q) use ($fecha){
                        //     return $q->whereDate('fecha_hora_vuelo_programado', $fecha);
                        // });
                    // });
                // })
            ->when($origen, function ($query) use ($origen) {
                $query->where('origen_id', $origen);
            })
            ->when($destino, function ($query) use ($destino) {
                $query->where('destino_id', $destino);
            })
            ->when($desde, function ($query) use ($desde) {
                $query->whereDate('fecha_hora_vuelo_programado', '>=', $desde);
            })
            ->when($hasta, function ($query) use ($hasta) {
                $query->whereDate('fecha_hora_vuelo_programado', '<=', $hasta);
            })
            ->when(strlen($search) > 5, function ($q) use ($search){
                $q->where('codigo', 'ilike', $search)
                ->orWhereHas("avion", function($q) use ($search){
                    return $q->where("descripcion", 'ilike', $search)
                        ->orWhere("matricula", 'ilike', $search);
                });
            });
    }

    public function scopeSearchVuelosInRuta($q, $filter){
        /*
            origen_id
            destino_id
            fecha_ida
            fecha_vuelta
        */
        $q
        ->where(function($q) use ($filter) {
            $q->when(isset($filter['origen_id']), function($q) use ($filter){
                $q->where('origen_id', $filter['origen_id']);
            })
            ->when(isset($filter['destino_id']), function($q) use ($filter){
                $q->where('destino_id', $filter['destino_id']);
            })
            ->when(isset($filter['fecha_ida']), function ($q) use ($filter){
                $q->whereDate('fecha_hora_vuelo_programado', $filter['fecha_ida']);
            });
        })
        ->orWhereHas('vuelo_ruta', function ($q) use ($filter){
            $q->when(isset($filter['origen_id']), function($q) use ($filter){
                $q->where('origen_id', $filter['origen_id']);
            })
            ->when(isset($filter['destino_id']), function($q) use ($filter){
                $q->where('destino_id', $filter['destino_id']);
            })
            ->when(isset($filter['fecha_ida']), function ($q) use ($filter){
                $q->whereDate('fecha_hora_vuelo_programado', $filter['fecha_ida']);
            });
        })->distinct();



        // $q->distinct()
        // ->when(isset($filter['destino_id']), function ($q) use ($filter){
        //     $q->join('vuelos as b', function ($q) use ($filter){
        //         $q->on('vuelos.vuelo_ruta_id', '=', 'b.vuelo_ruta_id')
        //         ->where('b.destino_id',$filter['destino_id'])
        //         ->whereRaw('b.stop_number > vuelos.stop_number');
        //     });
        // })
        // ->when(isset($filter['origen_id']), function($q) use ($filter){
        //     $q->where('vuelos.origen_id', $filter['origen_id']);
        // })
        // ->when(isset($filter['fecha_ida']), function ($q) use ($filter){
        //     $q->whereDate('vuelos.fecha_hora_vuelo_programado', $filter['fecha_ida']);
        // });
    }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }
    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            $model->codigo = date('Y')."-".$model->vuelo_ruta_id."-".$model->stop_number;
            $model->user_created_id = Auth::user()->id;
        });
        static::updating(function($model) {
            $model->user_updated_id = Auth::user()->id;
        });
        static::restoring(function($model) {
            $model->user_deleted_id = null;
        });
        self::deleting(function($model){
            $model->user_deleted_id = Auth::user()->id;
            $model->save();
        });
    }
}
