<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Equipaje extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pasaje_id',
        'vuelo_id',
        'peso',
        'importe',
        'igv',
        'descuento',
        'dimension_alto',
        'dimension_ancho',
        'dimension_largo',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    public function pasaje(): BelongsTo { return $this->belongsTo(Pasaje::class); }
    public function vuelo(): BelongsTo { return $this->belongsTo(Vuelo::class); }
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
