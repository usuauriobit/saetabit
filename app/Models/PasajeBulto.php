<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PasajeBulto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'pasaje_id',
        // 'tipo_bulto_id',
        'tarifa_bulto_id',
        'descripcion',
        'cantidad',
        'peso_total',
        'peso_excedido',
        'monto_exceso',
    ];

    public function getIsPagadoAttribute(){
        return optional(optional($this->venta_detalle)->venta)->has_movimiento;
    }
    public function getHasVentaDetalleAttribute(){
        return $this->venta_detalle;
    }
    public function getTipoBultoDescAttribute(){
        return optional(optional($this->tarifa_bulto)->tipo_bulto)->descripcion;
    }
    public function getTipoServicioAttribute()
    {
        return 'T';
    }
    public function getTotalContadoAttribute()
    {
        if(!$this->venta_detalle){
            return 0;
        }
        return optional(optional(optional($this->venta_detalle)->venta)->caja_movimiento)->whereNotIn('tipo_pago_id', [4])->sum('monto');
    }
    public function getTotalCreditoAttribute()
    {
        if(!$this->venta_detalle){
            return 0;
        }
        return optional(optional(optional($this->venta_detalle)->venta)->caja_movimiento)->whereIn('tipo_pago_id', [4])->sum('monto');
    }

    public function tarifa_bulto()  : BelongsTo { return $this->belongsTo(TarifaBulto::class); }
    public function pasaje()        : BelongsTo { return $this->belongsTo(Pasaje::class); }
    public function venta_detalle(){return $this->morphOne(VentaDetalle::class, 'documentable');}

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }
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
