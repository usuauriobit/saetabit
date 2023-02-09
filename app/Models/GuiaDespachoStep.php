<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GuiaDespachoStep extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'guia_despacho_id',
        'stepable_id',
        'stepable_type',
        'fecha',
    ];
    protected $casts = [
        'fecha' => 'datetime:Y-m-d g:i:a',
    ];

    public function getDistritoAttribute(){
        if($this->is_vuelo){
            return optional(optional($this->stepable->origen)->ubigeo)->distrito;
        }
        return optional($this->stepable->ubigeo)->distrito;
    }
    public function getIsVueloAttribute(){
        return $this->stepable_type == 'App\Models\Vuelo';
    }
    public function isVueloInicial($vuelo_id){
        return ($this->is_vuelo & ($this->stepable_id == $vuelo_id));
    }
    public function getCodigoAttribute(){
        return $this->is_vuelo
            ? $this->stepable->codigo
            : $this->stepable->descripcion;
    }

    public function getImporteTotalAttribute()
    {
        return $this->guia_despacho->total;
    }
    public function getPesoTotalAttribute()
    {
        return $this->guia_despacho->peso_total;
    }
    public function totalContado($vuelo_id)
    {
        return ($this->is_vuelo & ($this->stepable_id == $vuelo_id))
                    ? $this->guia_despacho->total_contado
                    : 0;

    }
    public function totalCredito($vuelo_id)
    {
        return ($this->is_vuelo & ($this->stepable_id == $vuelo_id))
                    ? $this->guia_despacho->total_credito
                    : 0;
    }

    public function stepable() { return $this->morphTo(); }
    public function guia_despacho() : BelongsTo { return $this->belongsTo(GuiaDespacho::class); }
    // public function vuelo()         : BelongsTo { return $this->belongsTo(Vuelo::class); }

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
