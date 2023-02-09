<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiempoAvionTramo extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'avion_id',
        'tramo_id',
        'tiempo_vuelo',
    ];
    /**
     * Get the avion that owns the TiempoAvionTramo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avion(): BelongsTo
    {
        return $this->belongsTo(Avion::class);
    }
    /**
     * Get the tramo that owns the TiempoAvionTramo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tramo(): BelongsTo
    {
        return $this->belongsTo(Tramo::class);
    }
}
