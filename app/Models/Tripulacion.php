<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Tripulacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'persona_id',
        'tipo_tripulacion_id',
        'nro_licencia',
        'fecha_vencimiento_licencia',
    ];

    protected $dates = ['fecha_vencimiento_licencia'];
    public function getNombreCompletoAttribute(){
        return optional($this->persona)->nombre_completo;
    }
    public function getNombreParcialAttribute(){
        return optional($this->persona)->nombre_parcial;
    }
    public function persona(): BelongsTo { return $this->belongsTo(Persona::class); }
    public function tipo_tripulacion(): BelongsTo { return $this->belongsTo(TipoTripulacion::class); }

    public function scopeWhereNombreLike($q, $search){
        return $q
        ->whereHas("persona", function($q) use ($search){
            return $q->whereNombreLike($search);
        });
    }
    public function scopeSearchFilter($q, $search){
        return $q->whereNombreLike($search)
        ->orWhereHas("tipo_tripulacion", function($q) use ($search){
            return $q->where("descripcion", "LIKE", $search);
        });
    }
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
