<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OficinaCuentaBancaria extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'oficina_id',
        'banco_id',
        'nro_cuenta',
        'nro_cci',
    ];

    public function getDescripcionCompletaAttribute()
    {
        return $this->oficina->descripcion . ' | ' . $this->banco->descripcion . ' | ' . $this->nro_cuenta;
    }

    public function oficina(): BelongsTo { return $this->belongsTo(Oficina::class); }
    public function banco(): BelongsTo { return $this->belongsTo(Banco::class); }
}
