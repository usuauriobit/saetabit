<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComprobanteCuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'comprobante_id',
        'nro_cuota',
        'fecha_pago',
        'importe',
    ];

    protected $dates = [ 'fecha_pago' ];

    /**
     * Get the comprobante that owns the ComprobanteCuota
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comprobante(): BelongsTo
    {
        return $this->belongsTo(Comprobante::class);
    }
}
