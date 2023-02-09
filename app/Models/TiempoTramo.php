<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TiempoTramo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tramo_id',
        'avion_id',
        'tiempo_vuelo',
    ];

    /**
     * Get the tramo that owns the TiempoTramo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tramo(): BelongsTo { return $this->belongsTo(Tramo::class); }
    /**
     * Get the avion that owns the TiempoTramo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avion(): BelongsTo { return $this->belongsTo(Avion::class); }
}
