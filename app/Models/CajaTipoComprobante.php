<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CajaTipoComprobante extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'caja_id',
        'tipo_comprobante_id',
        'serie',
        'correlativo_inicial',
    ];

    public function caja(): BelongsTo { return $this->belongsTo(Caja::class); }
    public function tipo_comprobante(): BelongsTo { return $this->belongsTo(TipoComprobante::class); }
}
