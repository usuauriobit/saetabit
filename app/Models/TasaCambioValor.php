<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TasaCambioValor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'fecha',
        'valor_venta',
    ];
    protected $dates = [
        'fecha'
    ];
    public function getIsDesactualizadoAttribute(){
        return $this->fecha->format('Y-m-d') !== Carbon::now()->format('Y-m-d');
    }
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
