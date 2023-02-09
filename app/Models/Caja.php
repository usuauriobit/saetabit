<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Caja extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'oficina_id',
        // 'cajero_id',
        'tipo_caja_id',
        'descripcion',
        'serie',
    ];
    public function oficina(): BelongsTo { return $this->belongsTo(Oficina::class); }
    public function movimientos(): HasMany { return $this->hasMany(CajaMovimiento::class, 'caja_id', 'id'); }
    // public function cajero(): BelongsTo { return $this->belongsTo(Personal::class, 'cajero_id', 'id'); }
    public function cajeros() { return $this->belongsToMany(Personal::class); }
    public function tipo_caja(): BelongsTo { return $this->belongsTo(TipoCaja::class); }
    public function comprobantes(): HasMany { return $this->hasMany(CajaTipoComprobante::class); }
    public function aperturas_cierres(): HasMany { return $this->hasMany(CajaAperturaCierre::class); }

    public function created_user(): BelongsTo { return $this->belongsTo(User::class, 'created_user_id', 'id'); }
    public function updated_user(): BelongsTo { return $this->belongsTo(User::class, 'updated_user_id', 'id'); }
    public function deleted_user(): BelongsTo { return $this->belongsTo(User::class, 'deleted_user_id', 'id'); }

    public function getAperturaPendienteAttribute(){
        return $this->aperturas_cierres()->whereNull('fecha_cierre')->first();
    }
    public function getAperturaCierreAttribute($current_date){
        return $this->aperturas_cierres()->whereDate('fecha_apertura', $current_date)->whereNotNull('fecha_cierre')->first();
    }
    public function getCanAperturarAttribute($current_date){
        return $current_date == date('Y-m-d')
            && !$this->has_already_apertura_abierta;
    }

    public function getHasAlreadyAperturaAbiertaAttribute(){
        return $this->aperturas_cierres()->whereNull('fecha_cierre')->exists();
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
