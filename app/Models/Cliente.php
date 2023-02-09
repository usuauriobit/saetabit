<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'ubigeo_id',
        'ruc',
        'razon_social',
        'nombre_comercial',
        'descripcion',
        'direccion',
    ];

    public function getPasajesAdquiridosAttribute(){
        return Pasaje::whereHas('venta_detalle.venta', function($q){
            $q->where('clientable_id', $this->id)
                ->where('clientable_type', 'App\Models\Cliente');
        })->get();
    }

    public function ventas(){return $this->morphMany(Venta::class, 'clientable');}
    public function cuentas_cobrar() { return $this->morphMany(CuentaCobrar::class, 'clientable'); }

    public function ubigeo(): BelongsTo { return $this->belongsTo(Ubigeo::class); }
    public function pasajes() : HasMany { return $this->hasMany(Pasaje::class, 'pasajero_id', 'id')->orderBy('created_at', 'desc'); }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id')->withTrashed(); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }

    public function getNombreCompletoAttribute()
    {
        return $this->razon_social;
    }

    public function getNombreCompletoInvertidoAttribute()
    {
        return $this->razon_social;
    }

    public function getNombreShortAttribute()
    {
        return $this->razon_social;
    }

    public function getNroDocAttribute()
    {
        return $this->ruc;
    }

    public function getTipoDocumentoIdAttribute()
    {
        return TipoDocumento::whereDescripcion('RUC')->first()->id;
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
