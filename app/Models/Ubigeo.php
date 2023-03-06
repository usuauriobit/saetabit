<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ubigeo extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'departamento',
        'provincia',
        'distrito',
        'geo_latitud',
        'geo_longitud',
    ];

    protected $appends = [
        'descripcion',
    ];
    public function ubicaciones(): HasMany{
        return $this->hasMany(Ubicacion::class);
    }
    public function getDescripcionAttribute(){
        return "{$this->distrito}, {$this->provincia}, {$this->departamento}";
    }

    public function scopeFilterSearch($q, $search){
        return $q->where('codigo', 'ilike', $search)
            ->orWhere('departamento', 'ilike', $search)
            ->orWhere('provincia', 'ilike', $search)
            ->orWhere('distrito', 'ilike', $search);
    }
}
