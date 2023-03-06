<?php

namespace App\Models;

use App\Services\DescuentoService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use App\Models\Traits\PasajeCambioAttributes;
class Pasaje extends Model
{
    use HasFactory, SoftDeletes, PasajeCambioAttributes;

    protected $fillable = [
        'checkin_date_time',
        'tipo_pasaje_id',
        'pasajero_id',
        'tarifa_id',
        'descuento_id',
        'orden_pasaje_id',
        // 'tipo_descuento_ruta_ida_vuelta_id',
        'oficina_id',
        'codigo',
        'importe',
        'monto_descuento',
        'importe_final',
        'importe_final_soles',
        'tasa_cambio',
        // 'descuento',
        'nro_asiento',
        'telefono',
        'email',
        'descripcion',
        'peso_persona',
        'fecha',
        'is_asiento_libre',
        'is_abierto',
        'is_asistido',
        'is_compra_web',
        'fecha_was_abierto',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',

        'observacion_anulado',

        'tipo_vuelo_id',
        'origen_id',
        'destino_id',
    ];

    protected $dates = ['fecha', 'fecha_was_abierto'];

    protected $casts = [
        'fecha' => 'datetime:Y-m-d',
        'fecha_was_abierto' => 'datetime:Y-m-d H g:i a',
    ];

    public const CAMBIO_TITULARIDAD_LIMIT_HOURS = [
        'comercial' => 1,
        'subvencionado' => 96,
    ];
    public const CAMBIO_RUTA_LIMIT_HOURS = [
        'comercial' => 24,
        'subvencionado' => 96,
    ];
    public const CAMBIO_FECHA_LIMIT_HOURS = [
        'comercial' => 24,
        'subvencionado' => 96,
    ];
    public const FECHA_ABIERTA_LIMIT_HOURS = [
        'comercial' => 24,
        'subvencionado' => 96,
    ];
    public function getTipoVueloDescAttribute(){
        if($this->is_comercial) return 'Comercial';
        if($this->is_subvencionado) return 'Subvencionado';
        return 'No definido';
    }

    public function getHasCheckinAttribute(){
        return !is_null($this->checkin_date_time);
    }
    // public function getFechaAttribute(){
    //     return optional($this->vuelo_origen)->fecha_hora_vuelo_programado;
    // }

    public function setTemporalIdAttribute($id){
        $this->attributes['temporal_id'] = $id;
    }
    // public function getDescuentoSolesCalcAttribute(){
    //     $monto_descuento = $this->descuento->getMonto($this->tarifa);
    //     return $this->is_dolarizado
    // }
    // public function getDescuentoDolaresCalcAttribute(){

    // }
    public function getImporteFinalCalcAttribute(){
        $monto_final = $this->importe;
        if($this->descuento){
            $monto_final = $this->descuento->getMonto($this->tarifa);
        }
        return $monto_final;
    }
    public function getIsImporteVariadoCalcAttribute(){
        return (float) $this->importe !== (float) $this->importe_final_calc;
    }
    public function getIsImporteVariadoAttribute(){
        return (float) $this->importe !== (float) $this->importe_final;
    }

    public function getHasVariosVuelosAttribute(){
        return $this->pasaje_vuelos->count() > 1;
    }
    public function getNombreShortAttribute(){
        return optional($this->pasajero)->nombre_short;
    }
    public function getNroDocAttribute(){
        return optional($this->pasajero)->nro_doc;
    }
    public function getHorarioEmbargueAttribute(){
        return optional(optional($this->vuelo_origen)->fecha_hora_vuelo_programado)->subHours(1);
    }
    public function getFechaVueloAttribute(){
        return optional(optional($this->vuelo_origen)->fecha_hora_vuelo_programado)->format('Y-m-d');
    }
    public function getFechaVueloObjAttribute(){
        return optional($this->vuelo_origen)->fecha_hora_vuelo_programado;
    }
    public function getFechaHoraVueloProgramadoAttribute(){
        return optional($this->vuelo_origen)->fecha_hora_vuelo_programado;
    }
    public function getTiempoVueloAttribute(){
        return $this->vuelo_origen->fecha_hora_aterrizaje_programado->diffInMinutes($this->vuelo_origen->fecha_hora_vuelo_programado);
    }
    public function getVueloOrigenAttribute(){
        return $this->vuelos()->orderBy('stop_number', 'asc')->first();
    }
    public function getVueloDestinoAttribute(){
        return $this->vuelos()->orderBy('stop_number', 'desc')->first();
    }
    public function getOcupaAsientoAttribute(){
        return optional($this->tarifa)->ocupa_asiento ?? true;
    }
    public function getVueloDescAttribute(){
        if($this->vuelo_origen){
            return optional(optional(optional($this->vuelo_origen)->origen)->ubigeo)->distrito
                    ." - "
                    .optional(optional(optional($this->vuelo_destino)->destino)->ubigeo)->distrito;
        }
        return optional(optional($this->origen)->ubigeo)->distrito
            ." - "
            .optional(optional($this->destino)->ubigeo)->distrito;
    }
    public function getGetOrigenAttribute(){
        if($this->vuelo_origen)
            return optional(optional($this->vuelo_origen)->origen);
        return $this->origen;
    }
    public function getGetDestinoAttribute(){
        if($this->vuelo_destino)
            return optional(optional($this->vuelo_destino)->destino);
        return $this->destino;
    }
    public function hasVuelo($vuelo_id){
        return (bool) $this->pasaje_vuelos()->where('vuelo_id', $vuelo_id)->first();
    }
    public function isFromVueloAnterior($vuelo_id){
        // dd($this->hasVuelo($vuelo_id));
        return $this->hasVuelo($vuelo_id);
    }
    public function getCanLiberarAttribute(){
        return
            !$this->is_abierto &&
            !$this->trashed() &&
            !$this->has_vuelo_finished ||
            (!$this->is_asistido && $this->pasaje_vuelos->count() > 0)
            && Auth::user()->can('intranet.comercial.pasaje.cambio.fecha-abierta.create');
    }
    public function getCanAnularAttribute(){
        return
            !$this->trashed() &&
            !$this->has_vuelo_finished &&
            !$this->is_pagado &&
            (!$this->is_asistido && $this->pasaje_vuelos->count() > 0)
            && Auth::user()->can('intranet.comercial.pasaje.anular');
    }
    public function getHasVueloFinishedAttribute(){
        foreach ($this->vuelos as $vuelo) {
            if($vuelo->is_closed) return true;
        }
        return false;
    }

    public function getCanExportBoardingPassAttribute(){
        return !$this->is_abierto && $this->is_pagado;
    }

    public function scopeFilter(
        $q, $search,
        $filter_option,
        $origen,
        $destino,
        $desde,
        $hasta,
    ){
		$search = '%'.$search .'%';
        return $q
        ->when($filter_option === 'sin_asignar_vuelo', function ($q){
            return $q->doesntHave('pasaje_vuelos');
        })
        ->when($filter_option === 'asignados_vuelo', function ($q){
            return $q->has('pasaje_vuelos');
        })
        ->when($filter_option === 'pasajes_sin_volar', function ($q){
            return $q->whereHas('vuelos', function ($q){
                return $q->where('hora_despegue', null);
            });
        })
        ->when($filter_option === 'pasajes_han_volado', function ($q){
            return $q->whereHas('vuelos', function ($q){
                return $q->where('hora_despegue', '!=', null);
            });
        })
        ->when($origen, function ($q) use ($origen) {
            return $q->whereHas('origen.ubigeo', function ($q) use ($origen) {
                return $q->where('distrito', 'ilike', "%{$origen}%");
            });
        })
        ->when($destino, function ($q) use ($destino) {
            return $q->whereHas('destino.ubigeo', function ($q) use ($destino) {
                return $q->where('distrito', 'ilike', "%{$destino}%");
            });
        })
        ->when($desde, function ($q) use ($desde) {
            return $q->whereDate('fecha', '>=', $desde);
        })
        ->when($hasta, function ($q) use ($hasta) {
            return $q->whereDate('fecha', '<=', $hasta);
        })
        ->when(strlen($search) > 5, function ($q) use ($search){
            $q
            ->whereHas('tipo_pasaje', function($q) use ($search){
                return $q->where('descripcion', 'ilike', $search)
                    ->orWhere('descripcion', 'ilike', $search);
            })
            ->orWhereHas('pasajero', function($q) use ($search){
                return $q->whereNombreLike($search);
            })
            // ->orWhereHas('tarifa', function($q) use ($search){
            //     return $q->where('descripcion', 'ilike', $search)
            //         ->orWhereHas('ruta', function($q) use ($search){
            //             return $q->whereHas('tramo', function($query) use ($search){
            //                 return $query->searchFilter($search);
            //             });
            //         });
            // })
            ->orWhere('telefono', 'ilike', $search)
            ->orWhere('fecha', 'ilike', $search);
        });
    }

    public function scopeWhereHasCheckin($q){
        $q->whereNotNull('checkin_date_time');
    }
    public function getIsPagadoAttribute(){
        return optional($this->venta_detalle)->has_venta_movimiento;
    }
    public function getStatusAttribute(){
        $estado = "Reservado";
        if($this->is_pagado)
            $estado = "Pagado";
        if($this->has_checkin)
            $estado = "Check-in";
        if($this->is_asiento_libre)
            $estado = "Asiento libre";
        return $estado;
    }
    public function getStatusBadgeColorAttribute(){
        $badge = [
            'Reservado' => 'badge-outline',
            'Pagado'    => 'badge-accent badge-outline',
            'Asiento libre'  => 'badge-success badge-outline',
            'Check-in'  => 'badge-success',
        ];
        return $badge[$this->status];
    }

    public function getNroBultosAttribute(){
        return optional($this->equipajes)->sum('cantidad');
    }
    public function getPesoBultosAttribute(){
        return optional($this->equipajes)->sum('peso_total') ?? 0;
    }

    // public function getFechaLimiteCambioAttribute(){
    //     return optional(optional($this->vuelo_origen)->fecha_hora_vuelo_programado)->subDay();
    // }

    // public function getCanRealizarCambiosAttribute(){
    //     $fecha_actual = Carbon::now();
    //     return optional($this->fecha_limite_cambio)->greaterThanOrEqualTo($fecha_actual);
    // }
    public function getMontoCambioAbiertoAttribute(){
        return PasajeCambioTarifa::where('categoria_vuelo_id', optional(optional($this->vuelo_origen)->tipo_vuelo)->categoria_vuelo_id)
            ->first()
            ->monto_cambio_abierto ?? 0;
    }
    public function getMontoCambioFechaAttribute(){
        return PasajeCambioTarifa::where('categoria_vuelo_id', optional(optional($this->vuelo_origen)->tipo_vuelo)->categoria_vuelo_id)
            ->first()
            ->monto_cambio_fecha ?? 0;
    }
    public function getMontoCambioTitularidadAttribute(){
        return PasajeCambioTarifa::where('categoria_vuelo_id', optional(optional($this->vuelo_origen)->tipo_vuelo)->categoria_vuelo_id)
            ->first()
            ->monto_cambio_titularidad ?? 0;
    }
    // public function getIsAbiertoAttribute(){
    //     return $this->pasaje_vuelos->count() == 0;
    // }
    public function getPasajeLiberacionAttribute(){
        return $this->pasaje_liberacion_historial->groupBy('codigo_historial');
    }
    public function pasaje_liberacion_historial(): HasMany {
        return $this->hasMany(PasajeLiberacionHistorial::class, 'pasaje_id', 'id')->orderBy('created_at', 'desc');
    }

    public function getRutaAttribute()
    {
        return $this->getOrigen->codigo_icao . ' - ' . $this->getDestino->codigo_icao;
    }

    public function getComprobantesAttribute(){

        $comprobantes = collect();

        // ['title' => 'Pasaje', 'detalle' =>
        $comprobante = $this->getComprobanteFromModel($this);
        if($comprobante){
            $comprobantes->push( (object) ['title' => 'Pasaje', 'detalle' => [ $comprobante ] ] );
        }

        // PUEDE DARSE EL CASO QUE MUCHOS BULTOS SE REGISTRARON EN UN SOLO COMPROBANTE
        // Y A SU VEZ PUEDE HABER VARIAS COMPROBANTES DE BULTOS, POR ESO SE HACE EL BUCLE
        // PERO SOLO NOS INTERESA EL PRIMERO REGISTREO DE CADA VENTA
        $detalle = [];
        foreach ($this->pasaje_bultos_con_detalle_venta->groupBy('venta_detalle.venta_id') as $pasaje_bultos){
            $comprobante = $this->getComprobanteFromModel($pasaje_bultos[0]);
            if($comprobante){
                $detalle[] = $comprobante;
            }
        }
        $comprobantes->push( (object) ['title' => 'Exceso de Equipaje / Traslado de Mascotas', 'detalle' => $detalle] );

        $detalle = [];
        foreach ($this->cambios_titularidad as $item){
            $comprobante = $this->getComprobanteFromModel($item);
            if($comprobante){
                $detalle[] = $comprobante;
            }
        }
        $comprobantes->push((object) ['title' => 'Cambios de titularidad', 'detalle' => $detalle]);

        $detalle = [];
        foreach ($this->cambios_fecha as $item){
            $comprobante = $this->getComprobanteFromModel($item);
            if($comprobante){
                $detalle[] = $comprobante;
            }
        }
        $comprobantes->push((object) ['title' => 'Cambios de titularidad', 'detalle' => $detalle]);

        $detalle = [];
        foreach ($this->cambios_ruta as $item){
            $comprobante = $this->getComprobanteFromModel($item);
            if($comprobante){
                $detalle[] = $comprobante;
            }
        }
        $comprobantes->push((object) ['title' => 'Cambios de titularidad', 'detalle' => $detalle]);

        return $comprobantes;
    }
    public function getComprobanteFromModel(Model $model){
        return optional(optional(optional($model->venta_detalle)->venta)->comprobante)->ultima_respuesta;
    }
    public function getIsDolarizadoAttribute(){
        // if($this->descuento)
        //     return optional($this->descuento)->is_dolarizado;
        return optional($this->tarifa)->is_dolarizado;
    }
    public function getTipoServicioAttribute()
    {
        return 'B';
    }
    public function getIsCharterAttribute(){
        return optional($this->tipo_vuelo)->is_charter;
    }
    public function getIsComercialAttribute(){
        return optional($this->tipo_vuelo)->is_comercial;
    }
    public function getIsSubvencionadoAttribute(){
        return optional($this->tipo_vuelo)->is_subvencionado;
    }
    public function getIsNoRegularAttribute(){
        return optional($this->tipo_vuelo)->is_no_regular;
    }

    public function getIsExpiredAttribute(){
        return Carbon::now()->greaterThan($this->fecha_vuelo);
    }

    public function venta_detalle(){ return $this->morphOne(VentaDetalle::class, 'documentable');}

    // public function pasaje_bulto()  : HasOne { return $this->hasOne(PasajeBulto::class); }
    public function pasaje_bultos() : HasMany { return $this->hasMany(PasajeBulto::class); }
    public function pasaje_bultos_con_detalle_venta() : HasMany { return $this->hasMany(PasajeBulto::class)->has('venta_detalle');}
    public function pasaje_bultos_sin_detalle_venta() : HasMany { return $this->hasMany(PasajeBulto::class)->doesntHave('venta_detalle'); }
    public function pasaje_bultos_para_generar_detalle_venta() : HasMany { return $this->hasMany(PasajeBulto::class)->doesntHave('venta_detalle')->where('monto_exceso', '>', 0); }
    public function equipajes()     : HasMany { return $this->hasMany(PasajeBulto::class)->whereHas('tarifa_bulto', fn($q) => $q->where('is_equipaje', true)); }
    public function descuento()     : BelongsTo { return $this->belongsTo(Descuento::class); }
    public function tipo_vuelo()    : BelongsTo { return $this->belongsTo(TipoVuelo::class); }
    public function origen()        : BelongsTo { return $this->belongsTo(Ubicacion::class, 'origen_id', 'id'); }
    public function destino()       : BelongsTo { return $this->belongsTo(Ubicacion::class, 'destino_id', 'id'); }
    public function tipo_pasaje()   : BelongsTo { return $this->belongsTo(TipoPasaje::class); }
    public function pasajero()      : BelongsTo { return $this->belongsTo(Persona::class, 'pasajero_id', 'id')->withTrashed(); }
    public function oficina()       : BelongsTo { return $this->belongsTo(Oficina::class); }
    public function tarifa()        : BelongsTo { return $this->belongsTo(Tarifa::class)->withTrashed(); }
    public function user_created(): BelongsTo { return $this->belongsTo(Avion::class, 'user_created_id', 'id')->withTrashed(); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }

    public function cambios_titularidad()   : HasMany { return $this->hasMany(PasajeCambio::class)->where('tipo_pasaje_cambio_id', TipoPasajeCambio::whereDescripcion('Cambio de titular')->first()->id)->withTrashed(); }
    public function cambios_fecha()         : HasMany { return $this->hasMany(PasajeCambio::class)->where('tipo_pasaje_cambio_id', TipoPasajeCambio::whereDescripcion('Cambio de fecha')->first()->id)->withTrashed(); }
    public function cambios_ruta()          : HasMany { return $this->hasMany(PasajeCambio::class)->where('tipo_pasaje_cambio_id', TipoPasajeCambio::whereDescripcion('Cambio de ruta')->first()->id)->withTrashed(); }
    public function pasaje_cambios()  : HasMany { return $this->hasMany(PasajeCambio::class); }

    public function pasaje_vuelos() : HasMany { return $this->hasMany(PasajeVuelo::class); }
    public function vuelos()        : BelongsToMany { return $this->belongsToMany(Vuelo::class, PasajeVuelo::class)->whereNull('pasaje_vuelos.deleted_at')->withTimestamps(); }

    /**
     * Get the oden_pasaje that owns the Pasaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function oden_pasaje(): BelongsTo
    {
        return $this->belongsTo(OrdenPasaje::class);
    }

    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            if(!$model->codigo){
                $model->codigo = $model->temporal_id;
            }

            $model->fecha = date('Y-m-d');
            if(Auth::user()){
                $model->user_created_id = Auth::user()->id;
            }
            // $model->importe_final = $model->importe_final_calc;
            unset($model->temporal_id);
        });
        static::updating(function($model) {
            $model->user_updated_id = Auth::user()->id;
            $model->importe_final = $model->importe_final_calc;
        });
        static::restoring(function($model) {
            $model->user_deleted_id = null;
        });
        self::deleting(function($model){
            $model->user_deleted_id = optional(Auth::user())->id ?? null;
            $model->pasaje_vuelos()->delete();
            $model->save();
        });
    }

    public static function calcularImporte($data){
        return Tarifa::where('ruta_id', $data['vuelo_ruta_id'])
            ->where('tipo_pasaje_id', $data['tipo_pasaje_id'])
            ->whereHas('ruta', function($q){
                return $q->where('tipo_vuelo_id', TipoVuelo::whereIsComercial()->first()->id);
            })
            ->first()
            ->precio;
    }
}
