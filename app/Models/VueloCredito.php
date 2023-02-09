<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class VueloCredito extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'vuelo_ruta_id',
        'clientable_id',
        'clientable_type',
        'fecha_pago',
        'monto',
        'is_pagado',
        'glosa',
    ];
    public $dates = [
        'fecha_pago'
    ];

    public function clientable(){ return $this->morphTo(); }
    public function vuelo_ruta()    : BelongsTo { return $this->belongsTo(VueloRuta::class);}
    // public function amortizaciones(): HasMany { return $this->hasMany(VueloCreditoAmortizacion::class); }
    // public function ultimo_pago()   : HasOne { return $this->hasOne(VueloCreditoAmortizacion::class); }
    public function amortizaciones() { return $this->morphMany(VueloCreditoAmortizacion::class, 'placelable'); }
    public function cuenta_cobrar_detalle() { return $this->morphOne(CuentaCobrarDetalle::class, 'documentable'); }
    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }

    public function getUltimaAmortizacionFechaAttribute()
    {
        return optional($this->ultima_amortizacion)->fecha_pago;
    }
    public function getUltimaAmortizacionAttribute()
    {
        return $this->amortizaciones()->orderBy('fecha_pago', 'desc')->first();
    }
    public function getMontoPagadoAttribute()
    {
        return $this->amortizaciones()->sum('monto');
    }
    public function getMontoPagoPendienteAttribute()
    {
        return $this->monto - $this->amortizaciones->sum('monto');
    }
    public function canCreateAmortizacion()
    {
        // return !$this->is_pagado &&
        //     Auth::user()->can('intranet.comercial.vuelo-credito-amortizacion.create');
        return true;
    }
    public function getCodigoAttribute()
    {
        return $this->id;
    }
    public function getMontoTotalAttribute()
    {
        return $this->monto;
    }
    public function getClienteAttribute()
    {
        return $this->clientable;
    }
    public function getPrecioUnitarioAttribute()
    {
        return round($this->monto_total / $this->cantidad, 2);
    }
    public function getCantidadAttribute()
    {
        return $this->vuelo_ruta->vuelos->count() ?? 1;
    }
    public function getConceptoAttribute()
    {
        return "Vuelo {$this->vuelo_ruta->tipo_vuelo->descripcion} - Ruta: " . $this->vuelo_ruta->descripcion_ruta;
    }


    public static function booted(){
        parent::booted();
        static::creating(function($model) {
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
