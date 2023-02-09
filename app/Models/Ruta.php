<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Ruta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tipo_vuelo_id',
        'tramo_id',
    ];

    public function getDescripcionAttribute(){
        return "{$this->tipo_vuelo->descripcion} -- {$this->tramo->descripcion}";
    }
    public function getInversoAttribute(){
        return Ruta::where('tipo_vuelo_id', $this->tipo_vuelo_id)
                ->whereHas('tramo', function($q){
                    return $q->whereOrigenId($this->tramo->destino_id)
                        ->whereEscalaId($this->tramo->escala_id)
                        ->whereDestinoId($this->tramo->origen_id);
                })
                ->first();
    }

    public function tipo_vuelo(): BelongsTo { return $this->belongsTo(TipoVuelo::class); }
    public function tramo(): BelongsTo { return $this->belongsTo(Tramo::class); }

    public function tarifas(): HasMany { return $this->hasMany(Tarifa::class); }

    public function getHasEscalaAttribute(){
        return (bool) $this->tramo->escala_id;
    }

    public function scopeWhereHasOrigenUbigeoId($q, $ubigeo_id){
        return $q->whereHas('tramo', function($q) use ($ubigeo_id){
            return $q->whereHas('origen', function ($q) use ($ubigeo_id){
                return $q->whereUbigeoId($ubigeo_id);
            });
        });
    }
    public function scopeWhereHasOrigenUbigeo($q, $search){
        return $q->whereHas('tramo', function($q) use ($search){
            return $q->whereHas('origen', function ($q) use ($search){
                return $q->whereHas('ubigeo', function ($q) use ($search){
                    return $q->filterSearch($search);
                });
            });
        });
    }
    public function scopeWhereDestinoUbigeo($q, $search){
        return $q->whereHas('tramo', function($q) use ($search){
            return $q->whereHas('destino', function ($q) use ($search){
                return $q->whereHas('ubigeo', function ($q) use ($search){
                    return $q->filterSearch($search);
                });
            });
        });
    }
    public function scopeWhereDestinableUbigeo($q, $search){
        return $q->whereHas('tramo', function($q) use ($search){
            return $q->whereHas('destino', function ($q) use ($search){
                return $q->whereHas('ubigeo', function ($q) use ($search){
                    return $q->filterSearch($search);
                });
            })->orWhereHas('escala', function ($q) use ($search){
                return $q->whereHas('ubigeo', function ($q) use ($search){
                    return $q->filterSearch($search);
                });
            });
        });
    }
    public function scopeWhereIsComercial($q){
        return $q->whereHas('tipo_vuelo', function($q){
            $q->whereIsComercial();
        });
    }
    public function scopeWhereIsNoRegular($q){
        return $q->whereHas('tipo_vuelo', function($q){
            $q->whereIsNotRegular();
        });
    }

    public function getIsComercialAttribute(){
        return $this->tipo_vuelo->descripcion === 'Comercial';
    }
    public function getIsSubvencionadoAttribute(){
        return $this->tipo_vuelo->descripcion === 'Subvencionado';
    }
    public function getIsDolarizadoAttribute(){
        return !$this->is_subvencionado;
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
