<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenPasaje extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'codigo',
        'fecha',
        'vuelo_origen_id',
        'vuelo_destino_id',
        'is_ida_vuelta',
    ];
    protected $dates = [
        'fecha'
    ];
    /**
     * Get all of the pasajes for the OrdenPasaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pasajes(): HasMany {
        return $this->hasMany(Pasaje::class);
    }
    /**
     * Get the vuelo_origen that owns the OrdenPasaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vuelo_origen(): BelongsTo
    {
        return $this->belongsTo(Vuelo::class, 'vuelo_origen_id', 'id');
    }
    /**
     * Get the vuelo_origen that owns the OrdenPasaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vuelo_destino(): BelongsTo
    {
        return $this->belongsTo(Vuelo::class, 'vuelo_destino_id', 'id');
    }
}
