<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class IncidenciaEscala extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable = [
        'vuelo_primario_id',
        'escala_ubicacion_id',
        'vuelo_secundario_generado_id',
        'descripcion',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    public function vuelo_primario(): BelongsTo { return $this->belongsTo(Vuelo::class, 'vuelo_primario_id', 'id')->withTrashed(); }
    public function vuelo_secundario_generado(): BelongsTo { return $this->belongsTo(Vuelo::class, 'vuelo_secundario_generado_id', 'id')->withTrashed(); }
    public function escala_ubicacion(): BelongsTo { return $this->belongsTo(Ubicacion::class, 'escala_ubicacion_id', 'id'); }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }
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
