<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class VueloMassive extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'tipo_vuelo_id',
        'ruta_id',

        'fecha_inicio',
        'fecha_final',
        'nro_asientos',

        'paquete',
        'nro_contrato',
        'monto_total',
        'cliente_id',

        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_final',
    ];

    protected $casts = [
        'fecha_inicio'  => 'datetime',
        'fecha_final'   => 'datetime',
    ];

    public function ruta(): BelongsTo { return $this->belongsTo(Ruta::class); }
    public function tipo_vuelo(): BelongsTo { return $this->belongsTo(TipoVuelo::class); }
    public function vuelos(): HasMany { return $this->hasMany(Vuelo::class); }
    public function cliente(): BelongsTo { return $this->belongsTo(Cliente::class); }
    // public function amortizaciones() { return $this->morphMany(VueloCreditoAmortizacion::class, 'placelable'); }
    public function cuenta_cobrar_detalle() { return $this->morphOne(CuentaCobrarDetalle::class, 'documentable'); }

    public function getPrecioUnitarioAttribute()
    {
        return round($this->monto_total / $this->cantidad, 2);
    }

    public function getCantidadAttribute()
    {
        return $this->vuelos->count();
    }

    public function getConceptoAttribute()
    {
        return ($this->tipo_vuelo_id == 3) ? $this->ruta->descripcion : '-';
    }

    public function scopeSearchFilter($q, $search){
        return $q->where('paquete', 'ilike', $search)
                ->orWhereHas('cliente', function($q) use ($search){
                    return $q->where('descripcion', 'ilike', $search)
                            ->orWhere('razon_social', 'ilike', $search);
                })
                ->orWhere('nro_contrato', 'ilike', $search)
                ->orWhere('monto_total', 'ilike', $search)
                ->orWhereDate('fecha_inicio', 'ilike', $search)
                ->orWhereDate('fecha_final', 'ilike' ,$search);
    }

    public function getCanDestroyAttribute(){
        return
            Auth::user()->can('intranet.programacion-vuelo.vuelo-massive.delete')
            && $this->vuelos->filter(function($vuelo){
                return $vuelo->guias_despacho_vuelo->count() >= 1
                    && $vuelo->vuelo_pasajes->count() >= 1;
            })->count() == 0;
    }

    public function scopeFilterSearch(
        $q,
        $search,
        $categoria_id = null,
        $desde = null,
        $hasta = null,
        $origen = null,
        $destino = null
    ){
        $search = '%'.$search .'%';
        $q->when($categoria_id, function($query) use ($categoria_id){
            $query->whereHas('tipo_vuelo', function ($query) use ($categoria_id) {
                $query->whereCategoriaVueloId($categoria_id);
            });
        })
        ->when($origen, function ($query) use ($origen) {
            $query->whereHas('ruta.tramo', function ($query) use ($origen) {
                $query->where('origen_id', $origen);
            });
        })
        ->when($destino, function ($query) use ($destino) {
            $query->whereHas('ruta.tramo', function ($query) use ($destino) {
                $query->where('destino_id', $destino);
            });
        })
        ->when($desde, function ($query) use ($desde) {
            $query->whereDate('fecha_inicio', '>=', $desde);
        })
        ->when($hasta, function ($query) use ($hasta) {
            $query->whereDate('fecha_inicio', '<=', $hasta);
        })
        ;
    }

    public function canCreateAmortizacion()
    {
        // return !$this->is_pagado &&
        //     Auth::user()->can('intranet.comercial.vuelo-credito-amortizacion.create');
        return true;
    }
    // public function getCanDeleteAttribute(){
    //     foreach ($this->vuelos as $vuelo) {
    //         if($vuelo->)
    //     }
    //     return true;
    // }

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
            $model->vuelos()->delete();
            $model->save();
        });
    }
}
