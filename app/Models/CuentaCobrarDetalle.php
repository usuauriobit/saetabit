<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CuentaCobrarDetalle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cuenta_cobrar_id',
        'documentable_id',
        'documentable_type',
        'cantidad',
        'precio_unitario',
        'concepto',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    public function cuenta_cobrar(): BelongsTo { return $this->belongsTo(CuentaCobrar::class); }
    public function documentable() { return $this->morphTo(); }

    public function getImporteAttribute()
    {
        return round($this->cantidad * $this->precio_unitario, 2);
    }
    public function getDisponibleEliminarAttribute()
    {
        return $this->cuenta_cobrar->amortizaciones->count() == 0;
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
