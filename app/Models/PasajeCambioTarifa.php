<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasajeCambioTarifa extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoria_vuelo_id',
        'monto_cambio_fecha',
        'monto_cambio_abierto',
        'monto_cambio_titularidad',
        'monto_cambio_ruta',
    ];

    public function categoria_vuelo(): BelongsTo
    {
        return $this->belongsTo(CategoriaVuelo::class);
    }
}
