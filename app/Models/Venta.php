<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Venta extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'oficina_id',
        'clientable_id',
        'clientable_type',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    public function oficina()       : BelongsTo { return $this->belongsTo(Oficina::class); }
    public function clientable(){ return $this->morphTo(); }
    public function detalle()       : HasMany { return $this->hasMany(VentaDetalle::class, 'venta_id', 'id'); }
    public function caja_movimiento() { return $this->morphMany(CajaMovimiento::class, 'documentable'); }
    public function comprobante() { return $this->morphOne(Comprobante::class, 'documentable'); }
    public function cuenta_cobrar_detalle() { return $this->morphOne(CuentaCobrarDetalle::class, 'documentable'); }
    // public function devolucion() { return $this->morphOne(Devolucion::class, 'placelable'); }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }

    public function getStatusAttribute()
    {
        $estado = "Sin pagar";
        // if($this->detalles->count() > 0)
        //     $estado = "Pagado";
        if($this->has_movimiento)
            $estado = "Pago incompleto";
        if($this->is_pagado)
            $estado = "Pagado";
        if($this->trashed())
            $estado = "Eliminado";
        return $estado;
    }
    public function getStatusBadgeColorAttribute()
    {
        $badge = [
            'Sin pagar' => 'badge-warning',
            'Pago incompleto'    => 'badge-warning badge-outline',
            'Pagado'  => 'badge-success',
            'Eliminado'  => 'badge-error badge-outline',
        ];
        return $badge[$this->status];
    }
    public function getCodigoAttribute(){
        return 'V-' . Str::padLeft($this->id, 6, '0');
    }
    public function getIsPagadoAttribute()
    {
        // Existen ventas que generan S/. 0.0 por eso se agrego la segunda validacion
        if (($this->importe == 0 & $this->caja_movimiento->count() == 0)) {
            return false;
        } else {
            return ($this->total_pagado >= $this->importe);
        }
        // dd(($this->total_pagado));
    }
    public function getHasMovimientoAttribute()
    {
        return $this->caja_movimiento->count() > 0;
    }
    public function getTotalPagadoAttribute()
    {
        return round($this->caja_movimiento->sum('total'), 2);
    }
    public function getTotalFacturadoAttribute()
    {
        return $this->comprobante->total_importe ?? 0;
    }
    public function getImporteAttribute()
    {
        return round($this->detalle->sum('monto'), 1);
    }
    public function getSaldoPorIngresarAttribute()
    {
        return round($this->importe - $this->total_pagado, 1);
    }
    public function getDescripcionAttribute()
    {
        return $this->detalle->implode('descripcion', ', ');
    }
    public function getConceptoAttribute()
    {
        return $this->descripcion;
    }
    public function getCantidadAttribute()
    {
        return 1;
    }
    public function getPrecioUnitarioAttribute()
    {
        return $this->importe;
    }
    public function getDescripcionClienteAttribute()
    {
        return optional($this->clientable ?? null)->razon_social ??
            optional($this->clientable ?? null)->nombre_completo ??
            '-';
    }
    public function getNroDocumentoAttribute()
    {
        return optional($this->clientable ?? null)->ruc ??
            optional($this->clientable ?? null)->nro_doc ??
            '-';
    }
    public function getDisponibleFacturarAttribute()
    {
        return ($this->caja_movimiento()->whereNotNull('solicitud_extorno_by')->count() == 0)
                && !isset($this->comprobante)
                && ($this->importe > 0);
    }
    public function getCorrelativoCompletoAttribute()
    {
        return ($this->comprobante) ? $this->comprobante->serie . "-" . $this->comprobante->correlativo : "-";
    }

    public static function booted()
    {
        parent::booted();
        static::creating(function($model) {
            if(!$model->oficina_id)
                $model->oficina_id = Auth::user()->oficinas[0]->id;
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
            $model->detalle()->delete();
            $model->save();
        });
    }
}
