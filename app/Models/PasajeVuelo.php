<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\Pivot;
class PasajeVuelo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'pasaje_id',
        'vuelo_id',
        'checkin_date',
    ];

    public function pasaje(): BelongsTo { return $this->belongsTo(Pasaje::class); }
    public function vuelo(): BelongsTo { return $this->belongsTo(Vuelo::class); }

    public function getTotalContadoAttribute()
    {
        return $this->pasaje->venta_detalle->venta->caja_movimiento->whereNotIn('tipo_movimiento_id', [4])->sum('monto');
    }

    public function getTotalCreditoAttribute()
    {
        return $this->pasaje->venta_detalle->venta->caja_movimiento->whereIn('tipo_movimiento_id', [4])->sum('monto');
    }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }
    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            if(Auth::user()){
                $model->user_created_id = Auth::user()->id;
            }
        });
        static::updating(function($model) {
            if(Auth::user()){
                $model->user_updated_id = Auth::user()->id;
            }
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
