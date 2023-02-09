<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarifaBulto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tipo_vuelo_id',
        'tipo_bulto_id',
        'peso_max',
        'monto_kg_excedido',
        'is_monto_editable',
        'is_monto_fijo',
        'is_equipaje',
    ];

    // protected $appends = [
    //     'tipo_bulto_desc',
    // ];
    public function tipo_bulto(): BelongsTo { return $this->belongsTo(TipoBulto::class)->withTrashed(); }
    public function tipo_vuelo(): BelongsTo { return $this->belongsTo(TipoVuelo::class); }
    /**
     * Get all of the pasaje_bultos for the TarifaBulto
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pasaje_bultos(): HasMany
    {
        return $this->hasMany(PasajeBulto::class, 'tarifa_bulto_id', 'id');
    }


    public function getTipoBultoDescAttribute(): string {
        return optional($this->tipo_bulto)->descripcion;
    }
    public function getIsAnimalAttribute():bool{
        return optional($this->tipo_bulto)->descripcion == 'Animal/mascota';
    }

}
