<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CajaAperturaCierreBillete extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'apertura_cierre_id',
        'denominacion_id',
        'cantidad'
    ];

    public function getTotalAttribute()
    {
        return round($this->denominacion->valor * $this->cantidad, 2);
    }

    public function apertura_cierre(): BelongsTo { return $this->belongsTo(CajaAperturaCierre::class, 'apertura_cierre_id', 'id'); }
    public function denominacion(): BelongsTo { return $this->belongsTo(DenominacionBillete::class, 'denominacion_id', 'id'); }
}
