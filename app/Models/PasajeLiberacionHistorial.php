<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PasajeLiberacionHistorial extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'pasaje_id',
        'pasaje_vuelo_anterior_id',
        'pasaje_vuelo_nuevo_id',
        'codigo_historial',
        'nota',
        'approved_by_id',
        'approved_observation',
    ];

    public function getIsAbiertoAttribute(){
        return !$this->is_asignado;
    }
    public function getIsAsignadoAttribute(){
        return !is_null($this->pasaje_vuelo_nuevo_id);
    }

    public function pasaje(): BelongsTo { return $this->belongsTo(Pasaje::class);}
    public function pasaje_vuelo_anterior(): BelongsTo { return $this->belongsTo(Vuelo::class, 'pasaje_vuelo_anterior_id', 'id')->withTrashed();}
    public function pasaje_vuelo_nuevo(): BelongsTo { return $this->belongsTo(Vuelo::class, 'pasaje_vuelo_nuevo_id', 'id')->withTrashed();}
    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }
    public function approved_by(): BelongsTo { return $this->belongsTo(User::class, 'approved_by_id', 'id')->withTrashed(); }

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
