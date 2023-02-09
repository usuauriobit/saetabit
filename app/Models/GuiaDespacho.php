<?php

namespace App\Models;

use App\Services\TasaCambioService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuiaDespacho extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'oficina_id',
        'origen_id',
        'destino_id',
        'remitente_id',
        'consignatario_id',
        'motivo_anulacion_id',
        'codigo',
        'fecha',
        'fecha_entrega',
        'is_saved',
        'approved_by_id',
        'is_free',
    ];

    protected $dates = ['fecha'];

    protected $casts = [
        'fecha' => 'datetime:Y-m-d',
        'fecha_entrega' => 'datetime:Y-m-d H:i',
    ];

    // public function venta_detalle(){return $this->morphOne(VentaDetalle::class, 'documentable');}
    public function guia_despacho_steps(): HasMany { return $this->hasMany(GuiaDespachoStep::class)->orderBy('fecha', 'asc'); }
    public function oficina()       : BelongsTo { return $this->belongsTo(Oficina::class); }
    public function destino()       : BelongsTo { return $this->belongsTo(Ubicacion::class); }
    public function origen()        : BelongsTo { return $this->belongsTo(Ubicacion::class); }
    public function remitente()     : BelongsTo { return $this->belongsTo(Persona::class, 'remitente_id', 'id'); }
    public function consignatario() : BelongsTo { return $this->belongsTo(Persona::class, 'consignatario_id', 'id'); }
    public function motivo_anulacion() : BelongsTo { return $this->belongsTo(MotivoAnulacion::class, 'motivo_anulacion_id', 'id'); }
    public function detalles()      : HasMany   { return $this->hasMany(GuiaDespachoDetalle::class)->withTrashed(); }
    // public function cuenta_cobrar_detalle() { return $this->morphOne(CuentaCobrarDetalle::class, 'documentable'); }
    // public function amortizaciones() { return $this->morphMany(VueloCreditoAmortizacion::class, 'placelable'); }
    public function user_created()  : BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id')->withTrashed(); }
    public function user_updated()  : BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted()  : BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }

    public function approved_by(): BelongsTo { return $this->belongsTo(User::class, 'approved_by_id', 'id')->withTrashed(); }

    public function getDescripcionAttribute(){
        return "{$this->codigo}: {$this->origen->distrito} ({$this->remitente->nombre_short} - {$this->remitente->nro_doc})
            - {$this->destino->distrito} ({$this->consignatario->nombre_short} - {$this->consignatario->nro_doc})";
    }

    public function getSubTotalAttribute()
    {
        return round($this->detalles->sum('importe'), 2);
    }
    public function getTotalIgvAttribute()
    {
        return round($this->igv*$this->sub_total/100, 2);
    }
    public function getTotalAttribute()
    {
        return round($this->sub_total + $this->total_igv, 2);
    }
    public function getCanManipulateAttribute(){
        // dd($this->trashed());
        // dd(!$this->vuelo && !$this->trashed());
        return !$this->vuelo
                && !$this->trashed()
                && !$this->is_saved;
    }
    public function getCanSetStepAttribute(){
        return !$this->trashed()
                && $this->is_saved
                && $this->is_pagado
                // && !$this->last_step_is_unfinished
                && !$this->is_entregado;
    }
    public function getReasonCantSetStepAttribute(){
        if($this->trashed()) return 'La guía de despacho ha sido eliminada';
        if(!$this->is_saved) return 'La guía de despacho no ha sido guardada';
        if(!$this->is_pagado) return 'La guía de despacho no ha sido pagada';
        if($this->last_step_is_unfinished) return 'La guía de despacho se encuentra en un vuelo';
        if($this->is_entregado) return 'La guía de despacho ya ha sido entregada';
        return '';
    }
    public function getRutaAttribute(){
        return "{$this->origen->distrito} - {$this->destino->distrito}";
    }
    public function getRutaIcaoAttribute(){
        return "{$this->origen->codigo_icao} - {$this->destino->codigo_icao}";
    }
    public static function getUltimoCodigo(){
        return GuiaDespacho::orderBy('fecha', 'desc')->first()->codigo ?? '-';
    }
    public static function generateCodigo(){
        $codigos = GuiaDespacho::withTrashed()->get('codigo')->pluck('codigo');
        $ultimo = $codigos->map(function ($item, $key) {
                                return (int) Str::after($item, date('Y').'-');
                            })->max();
        return date('Y').'-'.($ultimo+1);
    }
    public function getContenidoAttribute(){
        return $this->detalles->implode('descripcion', ', ');
    }
    public function getPesoTotalAttribute(){
        return $this->detalles->sum('peso');
    }
    public function getImporteTotalAttribute(){
            return $this->total;
    }
    public function getStatusAttribute(){
        $estado = "Sin procesar";
        if($this->is_pagado)
            $estado = "Pagado";
        if($this->detalles->count() > 0)
            $estado = "En almacén";
        if($this->guia_despacho_steps->count() > 0)
            $estado = "En camino";
        if($this->fecha_entrega)
            $estado = 'Entregado';
        if($this->trashed())
            $estado = "Anulado";
        return $estado;
    }
    public function getStatusBadgeColorAttribute(){
        $badge = [
            'Sin procesar'  => 'badge-outline',
            'Pagado'        => 'badge-outline badge-success',
            'En almacén'    => 'badge-warning',
            'En camino'     => 'badge-outline badge-warning',
            'Entregado'     => 'badge-success',
            'Anulado'       => 'badge-error',
        ];
        return $badge[$this->status];
    }
    public function getIsInDestinoAttribute(){
        return
            $this->guia_despacho_steps->count() > 0
            && $this->guia_despacho_steps->last()->stepable_type == 'App\Models\Oficina'
            && $this->destino->ubigeo_id == optional(optional($this->guia_despacho_steps->last())->stepable)->ubigeo_id;
    }
    public function getIsPagadoAttribute(){
        return
            $this->is_saved &&
            (
                $this->importe_total == 0 ||
                (bool) optional($this->detalles[0]->venta_detalle->venta ?? null)->is_pagado
            );
    }
    public function getTotalContadoAttribute()
    {
        $total = 0;
        foreach ($this->detalles as $detalle) {
            $total += optional(optional(optional($detalle->venta_detalle->venta ?? null)->caja_movimiento ?? null)->whereNotIn('tipo_pago_id', [4]) ?? null)->sum('monto');

        }
        return $total;
    }
    public function getTotalCreditoAttribute()
    {
        $total = 0;
        foreach ($this->detalles as $detalle)
            $total += optional(optional(optional($detalle->venta_detalle->venta ?? null)->caja_movimiento ?? null)->whereIn('tipo_pago_id', [4]) ?? null)->sum('monto');
        return $total;
    }
    // public function getTotalSolesCalculadoAttribute(){
    //     return (new TasaCambioService())->getMontoSoles($this->importe_total);
    // }
    // public function getImporteTotalSolesAttribute(){
    //     return (new TasaCambioService())->getMontoSoles($this->importe_total);
    // }
    public function getIsEntregadoAttribute(){
        return (bool) $this->fecha_entrega;
    }
    // public function getIsPagadoAttribute()
    // {
    //     return true;
    // }
    public function canCreateAmortizacion()
    {
        return true;
    }
    // public function getMontoPagadoAttribute()
    // {
    //     return 0;
    // }
    // public function getMontoPagoPendienteAttribute()
    // {
    //     return $this->total - $this->monto_pagado;
    // }

    public function getComprobanteAttribute(){
        return optional(optional(optional($this->detalles[0] ?? null)->venta_detalle ?? null)->venta ?? null)->comprobante;
    }

    public function getCantidadAttribute()
    {
        return 1;
    }

    public function getPrecioUnitarioAttribute()
    {
        return $this->total;
    }

    public function getConceptoAttribute()
    {
        return $this->descripcion;
    }

    public function getLastStepAttribute() {
        return $this->guia_despacho_steps()->orderBy('fecha', 'desc')->first();
    }
    public function getLastStepIsUnfinishedAttribute() {
        if(optional($this->last_step)->stepable_type == 'App\Models\Vuelo')
            return !$this->is_closed;
        return false;
    }


    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            $model->codigo = self::generateCodigo();
            $model->fecha = date('Y-m-d H:i:s');
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
            $model->detalles()->delete();
            $model->guia_despacho_steps()->delete();
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        // If no field was given, use the primary key
        if ($field === null) {
            $field = $this->getRouteKeyName();
        }
        // Apply where clause
        $query = $this->where($field, $value);
        // Conditionally remove the softdelete scope to allow seeing soft-deleted records
            $query->withoutGlobalScope(SoftDeletingScope::class);
        // Find the first record, or abort
        return $query->firstOrFail();
    }
    public function scopeFilter(
            $q,
            string|null $search,
            string|null  $ubigeoOrigenId,
            string|null $ubigeoDestinoId,
            string|null $from,
            string|null $to,
            string|null $nro_documento,
            string|null $estado,
        ){
		$search = '%'.$search .'%';
		$nro_documento = '%'.$nro_documento .'%';
        return $q
        ->when(!is_null($ubigeoOrigenId), function ($q) use ($ubigeoOrigenId){
            $q->whereHas('origen', function($q) use ($ubigeoOrigenId){
                $q->where('ubigeo_id', $ubigeoOrigenId);
            });
        })
        ->when(!is_null($ubigeoDestinoId), function ($q) use ($ubigeoDestinoId){
            $q->whereHas('destino', function($q) use ($ubigeoDestinoId){
                $q->where('destino_id', $ubigeoDestinoId);
            });
        })
        ->when($from, function ($q) use ($from){
            return $q->whereDate("fecha", ">=", $from);
        })
        ->when($to, function ($q) use ($to){
            return $q->whereDate("fecha", "<=", $to);
        })
        ->when(strlen($search) > 5, function ($q) use ($search) {
            $q->whereHas("remitente", function($q) use ($search){
                return $q->whereNombreLike($search);
            })
            ->orWhereHas("consignatario", function($q) use ($search){
                return $q->whereNombreLike($search);
            })
            ->orWhere("codigo", "LIKE", $search);
        })
        ->when(!is_null($estado) && $estado != 'todos', function($q) use ($estado){
            $q->when($estado == 'pendiente', function($q){
                $q->whereNull('fecha_entrega');
            })
            ->when($estado == 'entregado', function($q){
                $q->whereNotNull('fecha_entrega');
            });
        })
        ->when(strlen($nro_documento) > 3, function ($q) use ($nro_documento) {
            $q->whereHas("remitente", function($q) use ($nro_documento){
                return $q->where('nro_doc', 'like', $nro_documento);
            })
            ->orWhereHas("consignatario", function($q) use ($nro_documento){
                return $q->where('nro_doc', 'like', $nro_documento);
            });
        });
    }
    public function scopeFilterType($q, $type = null){

        return $q
        // ->orWhereHas("ruta", function($q) use ($search){
        //     return $q->where("descripcion", "LIKE", $search);
        // })
        ->when(is_null($type), function($q) use ($type){
            $q->withTrashed();
        })
        ->when($type == 'sin_procesar', function($q){
            $q->whereDoesntHave('detalles');
        })
        ->when($type == 'en_almacen', function($q){
            $q->whereDoesntHave('guia_despacho_steps');
        })
        ->when($type == 'en_camino', function($q){
            $q->whereHas('guia_despacho_steps')
                ->whereNull('fecha_entrega');
        })
        ->when($type == 'entregado', function($q){
            $q->whereNotNull('fecha_entrega');
        })
        ->when($type == 'anulado', function($q){
            $q->where('deleted_at', '!=', null);
        });
    }
    public function getTipoServicioAttribute()
    {
        return 'G';
    }
}
