<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Personal extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'oficina_id',
        'persona_id',
        'fecha_ingreso',
    ];
    protected $dates = [
        'fecha_ingreso'
    ];
    protected $casts = [
        'fecha_ingreso' => 'datetime:Y-m-d'
    ];
    protected $appends = ['descripcion'];

    public function getNombreCompletoAttribute(){
        return optional($this->persona)->nombre_completo;
    }
    public function getDescripcionAttribute()
    {
        return $this->nombre_completo;
    }

    public function scopeIndexFilter($q, String $search){
        return $q
            ->orWhereHas("oficina", function($q) use ($search){
                return $q->where("descripcion", 'ilike', $search);
            })
            ->orWhereHas("persona", function($q) use ($search){
                return $q->whereNombreLike($search);
            })
            ->orWhereDate("fecha_ingreso", $search);
    }
    public function oficina(): BelongsTo { return $this->belongsTo(Oficina::class); }
    public function persona(): BelongsTo { return $this->belongsTo(Persona::class); }
    // public function caja(): HasOne { return $this->hasOne(Caja::class, 'cajero_id', 'id'); }
    public function cajas() { return $this->belongsToMany(Caja::class); }
    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id')->withTrashed(); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }
    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            $model->user_created_id = Auth::user()->id ?? null;
        });
        static::updating(function($model) {
            $model->user_updated_id = Auth::user()->id ?? null;
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
