<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ubicacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'ubigeo_id',
        'tipo_pista_id',
        'descripcion',
        'codigo_iata',
        'codigo_icao',
        'geo_latitud',
        'geo_longitud',
        'is_permited',
    ];

    public $appends = ['ubigeo_desc', 'codigo_default', 'distrito'];
    public function getUbigeoDescAttribute(){
        return optional($this->ubigeo)->descripcion;
    }
    public function getCodigoDefaultAttribute(){
        return $this->codigo_icao;
    }
    public function getDistritoAttribute(){
        return optional($this->ubigeo)->distrito;
    }

    // public function getGeoLatitudAttribute(){
    //     $this->ubigeo->geo_latitud;
    // }
    // public function getGeoLongitudAttribute(){
    //     $this->ubigeo->geo_longitud;
    // }
    public function origenes(): HasMany { return $this->hasMany(Tramo::class, 'origen_id', 'id'); }
    public function escalas(): HasMany { return $this->hasMany(Tramo::class, 'escala_id', 'id'); }
    public function destinos(): HasMany { return $this->hasMany(Tramo::class, 'destino_id', 'id'); }

    public function ubigeo(): BelongsTo { return $this->belongsTo(Ubigeo::class); }
    public function tipo_pista(): BelongsTo { return $this->belongsTo(TipoPista::class); }


    public function scopeSearchFilter($q, $search){
        return $q->where('descripcion', 'ilike', $search)
            ->orWhere('codigo_iata', 'ilike', $search)
            ->orWhere('codigo_icao', 'ilike', $search)
            ->orWhereHas('tipo_pista', function($q) use ($search) {
                return $q->where('descripcion', 'ilike', $search);
            })
            ->orWhereHas('ubigeo', function($q) use ($search) {
                return $q->filterSearch($search);
            });
    }
    public function scopeWhereIsPermited($q){
        $q->has('origenes')
            ->has('destinos');
    }
    public function scopeWhereIsOrigenComercial($q){
        return  $q->whereHas('origenes', function($q){
            $q->whereIsComercial();
        });
    }
    public function scopeWhereIsDestinableFromOrigenComercial($q, $origen_id){
        $tramos_destino_id = Tramo::where('origen_id', $origen_id)
            ->whereIsComercial()
            ->select('destino_id')
            ->distinct()
            ->get();

        return $q->whereIn('id', $tramos_destino_id);


        // return  $q
        // ->whereHas('origenes', function($q) use ($origen_id){
        //     $q->where('origen_id', $origen_id)->whereIsComercial()
        //     ->where('destino', function($q){
        //         $q->whereIsComercial();
        //     });
        // });
    }
}
