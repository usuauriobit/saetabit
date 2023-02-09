<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class IncidenciaFecha extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'vuelo_id',
        'fecha_hora_vuelo_anterior',
        'fecha_hora_aterrizaje_anterior',
        'fecha_hora_vuelo_posterior',
        'fecha_hora_aterrizaje_posterior',
        'descripcion',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];
    protected $casts = [
        'fecha_hora_vuelo_anterior' => 'datetime',
        'fecha_hora_aterrizaje_anterior' => 'datetime',
        'fecha_hora_vuelo_posterior' => 'datetime',
        'fecha_hora_aterrizaje_posterior' => 'datetime',
    ];
    public function vuelo(): BelongsTo { return $this->belongsTo(Vuelo::class); }

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
