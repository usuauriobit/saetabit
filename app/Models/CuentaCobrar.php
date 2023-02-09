<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CuentaCobrar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'oficina_id',
        'clientable_id',
        'clientable_type',
        'importe',
        'fecha_registro',
        'is_pagado',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    protected $dates = ['fecha_registro'];

    public function clientable() { return $this->morphTo(); }
    public function detalles(): HasMany { return $this->hasMany(CuentaCobrarDetalle::class); }
    public function amortizaciones(): HasMany { return $this->hasMany(CuentaCobrarAmortizacion::class); }
    public function comprobante() { return $this->morphOne(Comprobante::class, 'documentable'); }
    public function oficina(): BelongsTo { return $this->belongsTo(Oficina::class); }

    public function getCodigoAttribute()
    {
        return 'CC-' . Str::padLeft($this->id, 6, '0');
    }
    public function getNombreClienteAttribute()
    {
        return $this->clientable->razon_social ?? $this->clientable->nombre_completo;
    }
    public function getNroDocClienteAttribute()
    {
        return $this->clientable->ruc ?? $this->clientable->nro_doc;
    }
    public function getImporteAttribute()
    {
        return $this->detalles->sum('importe');
    }
    public function getImportePagadoAttribute()
    {
        return $this->amortizaciones->sum('monto');
    }
    public function getSaldoAttribute()
    {
        return $this->importe - $this->importe_pagado;
    }
    public function getDisponibleFacturarAttribute()
    {
        return (!$this->detalles->contains('documentable_type', Venta::class) & !$this->comprobante & $this->canCreateAmortizacion());
    }
    public function canCreateAmortizacion()
    {
        return $this->detalles->count() > 0;
    }


    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            $model->user_created_id = Auth::user()->id;
            $model->oficina_id = Auth::user()->personal->oficina_id;
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
