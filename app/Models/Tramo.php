<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tramo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'origen_id',
        'escala_id',
        'destino_id',
        'minutos_vuelo',
    ];

    public function getDescripcionAttribute(){
        $data = $this->origen->ubigeo->distrito.' -- ';
        if($this->escala)
            $data .= $this->escala->ubigeo->distrito.' -- ';
        $data .= $this->destino->ubigeo->distrito;
        return $data;
    }
    public function getInversoAttribute(){
        return Tramo::whereOrigenId($this->destino_id)
                ->whereEscalaId($this->escala_id)
                ->whereDestinoId($this->origen_id)
                ->first();
    }

    public function rutas(): HasMany { return $this->hasMany(Ruta::class); }

    public function escala()    : BelongsTo { return $this->belongsTo(Ubicacion::class, 'escala_id', 'id'); }
    public function origen()    : BelongsTo { return $this->belongsTo(Ubicacion::class, 'origen_id', 'id'); }
    public function destino()   : BelongsTo { return $this->belongsTo(Ubicacion::class, 'destino_id', 'id'); }

    public function scopeSearchFilter($q, $search){
        return $q->whereHas('origen', function($q) use ($search) {
            return $q->searchFilter($search);
        })
        ->orWhereHas('escala', function($q) use ($search) {
            return $q->searchFilter($search);
        })
        ->orWhereHas('destino', function($q) use ($search) {
            return $q->searchFilter($search);
        });
    }
    public function scopeWhereHasOrigenUbigeo($q, $search){
        return $q->whereHas('origen', function ($q) use ($search){
            return $q->whereHas('ubigeo', function ($q) use ($search){
                return $q->filterSearch($search);
            });
        });
    }
    public function scopeWhereDestinoUbigeo($q, $search){
        return $q->whereHas('destino', function ($q) use ($search){
            return $q->whereHas('ubigeo', function ($q) use ($search){
                return $q->filterSearch($search);
            });
        });
    }
    public function scopeWhereIsComercial($q){
        $q->whereHas('rutas', function($q){
            $q->where('tipo_vuelo_id', TipoVuelo::whereDescripcion('Comercial')->first()->id);
        });
    }
}
