<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class VentaDetalle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'venta_id',
        'descripcion',
        'cantidad',
        'monto',
        'tasa_cambio',
        'monto_dolares',
        'documentable_id',
        'documentable_type',
    ];

    public function venta()     : BelongsTo { return $this->belongsTo(Venta::class)->withTrashed(); }
    public function documentable(){ return $this->morphTo(); }
    public function descuento() { return $this->morphOne(Descuento::class, 'documentable'); }
    public function devolucion() { return $this->morphOne(Devolucion::class, 'placelable'); }
    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }

    public function getHasVentaMovimientoAttribute(){
        return optional($this->venta)->has_movimiento;
    }

    public function getImporteAttribute(){
        return round($this->cantidad * $this->monto, 2);
    }
    public function getImporteDolaresAttribute() {
        return round($this->cantidad * $this->monto_dolares, 2);
    }
    public function getTipoServicioAttribute()
    {
        return optional($this->documentable ?? null)->tipo_servicio ?? '-';
    }
    public function getCanDevolucionAttribute()
    {
        if ($this->documentable_type == 'App\Models\Pasaje') {
            return !(optional($this->documentable)->has_vuelo_finished);
        }

        if ($this->documentable_type == 'App\Models\GuiaDespacho') {
            return ($this->documentable->status == 'Pagado' || $this->documentable->status == 'En almacén');
        }

        return false;
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
