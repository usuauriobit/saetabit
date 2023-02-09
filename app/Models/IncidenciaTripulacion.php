<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class IncidenciaTripulacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $fillable = [
        'vuelo_id',
        'tripulacion_vuelo_before_id',
        'tripulacion_vuelo_after_id',
        'descripcion',
    ];

    public function setActuallyInVueloAttribute(){
        !$this->tripulacion_vuelo_after->trashed();
    }

    public function vuelo(): BelongsTo { return $this->belongsTo(Vuelo::class); }
    public function tripulacion_vuelo_before(): BelongsTo { return $this->belongsTo(TripulacionVuelo::class, 'tripulacion_vuelo_before_id', 'id')->withTrashed(); }
    public function tripulacion_vuelo_after(): BelongsTo { return $this->belongsTo(TripulacionVuelo::class, 'tripulacion_vuelo_after_id', 'id')->withTrashed(); }

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
