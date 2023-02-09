<?php

namespace App\Models;

use App\Services\TasaCambioService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuiaDespachoDetalle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'guia_despacho_id',
        'descripcion',
        'peso',
        'is_sobre',
        'cantidad',
        'largo',
        'ancho',
        'alto',
        'importe',
    ];

    public function getDimensionesAttribute()
    {
        return "{$this->largo} cm x {$this->ancho} cm x {$this->alto} cm";
    }
    public function getTipoServicioAttribute()
    {
        return 'G';
    }
    // public function getImporteSolesAttribute(){
    //     $tasa_cambio = optional(optional($this->guia_despacho)->venta_detalle)->tasa_cambio;
    //     return (new TasaCambioService())->getMontoSoles($this->importe, $tasa_cambio);
    // }
    public function guia_despacho(): BelongsTo { return $this->belongsTo(GuiaDespacho::class); }
    public function venta_detalle(){return $this->morphOne(VentaDetalle::class, 'documentable');}

}
