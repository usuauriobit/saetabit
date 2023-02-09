<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Escala extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vuelo_id',
        'escala_origen_id',
        'escala_id',
        'hora_programada_aterrizaje',
        'hora_programada_despegue',
        'hora_aterrizaje',
        'hora_despegue',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    protected $dates = [
        'hora_programada_aterrizaje',
        'hora_programada_despegue',
        'hora_aterrizaje',
        'hora_despegue',
    ];

    protected $casts = [
        'hora_programada_aterrizaje' => 'datetime:H:i',
        'hora_programada_despegue' => 'datetime:H:i',
        'hora_aterrizaje' => 'datetime:H:i',
        'hora_despegue' => 'datetime:H:i',
    ];

    public function vuelo(): BelongsTo { return $this->belongsTo(Vuelo::class); }
    public function escala_origen(): BelongsTo { return $this->belongsTo(Ubicacion::class, 'escala_origin_id', 'id'); }
    public function escala(): BelongsTo { return $this->belongsTo(Ubicacion::class, 'escala_id', 'id'); }
}
