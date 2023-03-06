<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Avion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipo_motor_id',
        'estado_avion_id',
        'fabricante_id',
        'descripcion',
        'modelo',
        'matricula',
        'nro_asientos',
        'nro_pilotos',
        'peso_max_pasajeros',
        'peso_max_carga',
        'fecha_fabricacion',
    ];

    protected $dates = ['fecha_fabricacion'];

    protected $casts = [
        'fecha_fabricacion' => 'datetime:Y-m-d'
    ];

    public function tipo_motor()     : BelongsTo { return $this->belongsTo(TipoMotor::class, 'tipo_motor_id', 'id'); }
    public function estado()    : BelongsTo { return $this->belongsTo(EstadoAvion::class, 'estado_avion_id', 'id'); }
    public function fabricante(): BelongsTo { return $this->belongsTo(Fabricante::class); }

    public function scopeSearchFilter($q, $search){
        return $q->whereHas("tipo_motor", function($q) use ($search){
            return $q->where("descripcion", 'ilike', $search);
        })
        ->orWhereHas("estado", function($q) use ($search){
            return $q->where("descripcion", 'ilike', $search);
        })
        ->orWhereHas("fabricante", function($q) use ($search){
            return $q->where("descripcion", 'ilike', $search);
        })
        ->orWhere("nro_asientos", 'ilike', $search)
        ->orWhere("nro_pilotos", 'ilike', $search)
        ->orWhere("peso_max_pasajeros", 'ilike', $search)
        ->orWhere("peso_max_carga", 'ilike', $search)
        ->orWhere("fecha_fabricacion", 'ilike', $search)
        ->orWhere("descripcion", 'ilike', $search)
        ->orWhere("modelo", 'ilike', $search)
        ->orWhere("matricula", 'ilike', $search);
    }

    /**
     * Get all of the avion_tiempo_tramos for the Avion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiempo_avion_tramos(): HasMany {
        return $this->hasMany(TiempoAvionTramo::class);
    }

    // public function getTiempoAvionTramosFilteredAttribute(){
    //     $tramos = [];
    //     foreach ($this->tiempo_avi as $key => $value) {
    //         if()
    //     }
    // }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id')->withTrashed(); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }
    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            $model->user_created_id = Auth::user()->id;
        });
        static::updating(function($model) {
            $model->user_updated_id = Auth::user()->id;
        });
        static::restoring(function($model) {
            $model->user_deleted_id = null;
        });
        self::deleting(function($model){
            $model->user_deleted_id = Auth::user()->id;
            $model->save();
        });
    }
}
