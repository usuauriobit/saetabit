<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CajaAperturaCierre extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'caja_id',
        'fecha_apertura',
        'fecha_cierre',
        'observacion_apertura',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    protected $dates = ['fecha_apertura','fecha_cierre'];

    public function caja(): BelongsTo { return $this->belongsTo(Caja::class); }
    public function movimientos(): HasMany { return $this->hasMany(CajaMovimiento::class, 'apertura_cierre_id', 'id'); }
    public function billetes(): HasMany { return $this->hasMany(CajaAperturaCierreBillete::class, 'apertura_cierre_id', 'id'); }
    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'created_user_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'updated_user_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'deleted_user_id', 'id'); }

    public function getCodigoAttribute()
    {
        return Str::of($this->id)->padLeft(7, '0');
    }

    public function getTotalRecaudadoAttribute()
    {
        return round($this->movimientos->sum('total'), 1);
    }
    public function getTotalEfectivoAttribute()
    {
        return round($this->movimientos->where('tipo_pago_id', 1)->sum('total'), 1);
    }
    public function getTotalCreditosAttribute()
    {
        return round($this->movimientos->where('tipo_pago_id', 4)->sum('total'), 1);
    }
    public function getTotalBilletesAttribute()
    {
        return round($this->billetes->sum('total'), 1);
    }
    public function getTotalDepositosAttribute()
    {
        return round($this->movimientos_depositos->sum('total'), 1);
    }

    public function getIsAperturadaAttribute()
    {
        return $this->fecha_cierre != null;
    }

    public function getMovimientosTarjetaAttribute($tarjeta_id)
    {
        return $this->movimientos()->whereTarjetaId($tarjeta_id)->get();
    }

    public function getMovimientosDepositosAttribute()
    {
        return $this->movimientos()->whereTipoPagoId(3)->get();
    }

    public static function booted()
    {
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
