<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class PasajeCambio extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'tipo_pasaje_cambio_id',
        'pasajero_anterior_id',
        'pasajero_nuevo_id',
        'pasaje_id',
        'importe_penalidad',
        'importe_adicional',
        'igv',
        'descuento',
        'nota',
        'fecha_autorize',
        'is_sin_pagar',
        'is_confirmado',
        'user_autorize_id',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',

        'approved_by_id',
        'approved_observation'
    ];

    public $dates = [
        'fecha_autorize'
    ];

    public function getCanEliminarAttribute(){
        return !$this->pasaje->is_expired
            && (!$this->venta_detalle || !$this->venta_detalle->has_venta_movimiento) ;
    }

    public function getImporteTotalAttribute(){
        if($this->venta_detalle){
            return $this->venta_detalle->importe;
        }
        return $this->importe_penalidad + $this->importe_adicional;
    }

    // public function getCambioRutaDescAttribute(){
    //     return $this->cambio_vuelo_origen->vuelo->ruta_descripcion
    // }

    public function getCambioVueloOrigenAnteriorAttribute(){
        return $this->pasaje_cambio_vuelos_anteriores->sortBy('vuelo.stop_number')->first();
    }
    public function getCambioVueloDestinoAnteriorAttribute(){
        return $this->pasaje_cambio_vuelos_anteriores->sortByDesc('vuelo.stop_number', 'desc')->first();
    }
    public function getCambioVueloOrigenPosteriorAttribute(){
        return $this->pasaje_cambio_vuelos_posteriores->sortBy('vuelo.stop_number')->first();
    }
    public function getCambioVueloDestinoPosteriorAttribute(){
        return $this->pasaje_cambio_vuelos_posteriores->sortByDesc('vuelo.stop_number')->first();
    }
    public function getTipoServicioAttribute()
    {
        return 'P';
    }
    public function getTotalContadoAttribute()
    {
        return $this->venta_detalle->venta->caja_movimiento->whereNotIn('tipo_pago_id', [4])->sum('monto');
    }
    public function getTotalCreditoAttribute()
    {
        return $this->venta_detalle->venta->caja_movimiento->whereIn('tipo_pago_id', [4])->sum('monto');
    }

    public function venta_detalle(){return $this->morphOne(VentaDetalle::class, 'documentable');}

    public function tipo_pasaje_cambio(): BelongsTo { return $this->belongsTo(TipoPasajeCambio::class); }
    public function pasaje()            : BelongsTo { return $this->belongsTo(Pasaje::class, 'pasaje_id', 'id')->withTrashed(); }

    public function pasajero_anterior() : BelongsTo { return $this->belongsTo(Persona::class, 'pasajero_anterior_id', 'id')->withTrashed(); }
    public function pasajero_nuevo()    : BelongsTo { return $this->belongsTo(Persona::class, 'pasajero_nuevo_id', 'id')->withTrashed(); }

    public function pasaje_cambio_vuelos()              : HasMany { return $this->hasMany(PasajeCambioVuelo::class); }
    public function pasaje_cambio_vuelos_anteriores()   : HasMany { return $this->hasMany(PasajeCambioVuelo::class)->where('is_anterior', true); }
    public function pasaje_cambio_vuelos_posteriores()  : HasMany { return $this->hasMany(PasajeCambioVuelo::class)->where('is_anterior', false); }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id')->withTrashed(); }
    public function approved_by(): BelongsTo { return $this->belongsTo(User::class, 'approved_by_id', 'id')->withTrashed(); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }

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
