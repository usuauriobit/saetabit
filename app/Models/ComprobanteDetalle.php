<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ComprobanteDetalle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'comprobante_id',
        'unidad_medida_id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    public function comprobante(): BelongsTo { return $this->belongsTo(Comprobante::class); }
    public function unidad_medida(): BelongsTo { return $this->belongsTo(UnidadMedida::class); }
    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }

    public function getImporteAttribute()
    {
        return round($this->cantidad * $this->precio_unitario, 2);
    }

    public static function booted(){
        parent::booted();
        static::creating(function($model){
            $model->created_user_id = Auth::user()->id ?? null;
        });
        static::updating(function($model) {
            $model->updated_user_id = Auth::user()->id ?? null;
        });
        static::restoring(function($model) {
            $model->deleted_user_id = null;
        });
        self::deleting(function($model){
            $model->deleted_user_id = Auth::user()->id ?? null;
            $model->save();
        });
    }
}
