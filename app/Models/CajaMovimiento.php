<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CajaMovimiento extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'caja_id',
        'apertura_cierre_id',
        'tipo_movimiento_id',
        'cuenta_bancaria_id',
        'tipo_pago_id',
        'tarjeta_id',
        'documentable_id',
        'documentable_type',
        'monto',
        'fecha',
        'fecha_pago',
        'fecha_credito',
        // 'is_pagado',
        'nro_operacion',
        'nro_cuotas',
        'porcentaje_cargo',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
        'solicitud_extorno_by',
        'solicitud_extorno_date',
        'solicitud_extorno_aproved_by',
        'motivo_extorno',
    ];
    protected $dates = [
        'fecha',
        'fecha_pago',
        'solicitud_extorno_date'
    ];

    public function caja(): BelongsTo { return $this->belongsTo(Caja::class); }
    public function apertura_cierre(): BelongsTo { return $this->belongsTo(CajaAperturaCierre::class, 'apertura_cierre_id', 'id'); }
    public function tipo_movimiento(): BelongsTo { return $this->belongsTo(TipoMovimiento::class); }
    public function cuenta_bancaria(): BelongsTo { return $this->belongsTo(CuentaBancaria::class); }
    public function tipo_pago(): BelongsTo { return $this->belongsTo(TipoPago::class); }
    public function tarjeta(): BelongsTo { return $this->belongsTo(Tarjeta::class); }
    public function documentable() { return $this->morphTo()->withTrashed(); }

    public function created_user(): BelongsTo { return $this->belongsTo(User::class, 'created_user_id', 'id'); }
    public function updated_user(): BelongsTo { return $this->belongsTo(User::class, 'updated_user_id', 'id'); }
    public function deleted_user(): BelongsTo { return $this->belongsTo(User::class, 'deleted_user_id', 'id'); }
    public function solicitud_extorno_por(): BelongsTo { return $this->belongsTo(User::class, 'solicitud_extorno_by', 'id'); }
    public function solicitud_extorno_aprovado_por(): BelongsTo { return $this->belongsTo(User::class, 'solicitud_extorno_aproved_by', 'id'); }

    public function getCodigoAttribute()
    {
        return Str::padLeft($this->id, 6, '0');
    }

    public function getIsIngresoAttribute()
    {
        return $this->tipo_movimiento->is_ingreso;
    }

    public function getCargoAttribute()
    {
        return round(((double) $this->porcentaje_cargo / 100) * $this->monto, 1);
    }

    public function getTotalAttribute()
    {
        return round($this->monto + $this->cargo, 2);
    }

    public function getSerieAttribute()
    {
        return optional(optional($this->documentable ?? null)->comprobante ?? null)->serie ?? '-';
    }

    public function getCorrelativoAttribute()
    {
        return optional(optional($this->documentable ?? null)->comprobante ?? null)->correlativo ?? '-';
    }

    public function getSerieCorrelativoAttribute()
    {
        return $this->serie . '-' . $this->correlativo;
    }

    public function getTipoComprobanteAttribute()
    {
        return optional(optional(optional($this->documentable ?? null)->comprobante ?? null)->tipo_comprobante ?? null)->abreviatura ?? '-';
    }

    public function getTipoServicioAttribute()
    {
        return optional($this->documentable->detalle[0] ?? null)->tipo_servicio ?? null;
    }

    public function getRutaAttribute()
    {
        $ruta = '';

        foreach ($this->documentable->detalle as $detalle) {
            if ($detalle->documentable_type == 'App\\Models\\Pasaje')
                $ruta = optional($detalle->documentable ?? null)->ruta;

            if ($detalle->documentable_type == 'App\\Models\\GuiaDespacho')
                $ruta = optional($detalle->documentable ?? null)->ruta_icao;
        }

        return $ruta;
    }

    public function getTipoOperacionAttribute()
    {
        $operacion = '';

        foreach ($this->documentable->detalle as $detalle) {
            if ($detalle->documentable_type == 'App\\Models\\Pasaje')
                $operacion = Str::replace('App\\Models\\', '', $detalle->documentable_type);

            if ($detalle->documentable_type == 'App\\Models\\GuiaDespacho')
                $operacion = Str::replace('App\\Models\\', '', $detalle->documentable_type);
        }

        return $operacion;
    }

    public function scopeSinFacturar($query, $caja)
    {
        $query->whereCajaId($caja->id)
            ->whereHasMorph('documentable', [Venta::class], function ($query) {
                $query->doesntHave('comprobante');
            });
    }

    public static function booted(){
        parent::booted();
        static::creating(function($model){
            $model->created_user_id = Auth::user()->id ?? null;
        });
        static::updating(function($model) {
            $model->updated_user_id = Auth::user()->id ?? null;
        });
        static::restoring(function($model) {
            $model->deleted_user_id = null;
        });
        self::deleting(function($model){
            $model->deleted_user_id = Auth::user()->id ?? null;
            $model->save();
        });
    }
}
