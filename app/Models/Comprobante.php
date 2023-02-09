<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Services\FacturacionService;
use Illuminate\Support\Str;

class Comprobante extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'documentable_id',
        'documentable_type',
        'comprobante_modifica_id',
        'caja_apertura_cierre_id',
        'caja_id',
        'moneda_id',
        'tipo_documento_id',
        'tipo_comprobante_id',
        'tipo_pago_id',
        'tipo_nota_credito_id',
        'serie',
        'correlativo',
        'nro_documento',
        'denominacion',
        'direccion',
        'fecha_emision',
        'fecha_vencimiento',
        'fecha_credito',
        'nro_cuotas',
        'observaciones',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
        'motivo_anulacion',
        'anulacion_by',
    ];

    protected $dates = ['fecha_emision', 'fecha_vencimiento','fecha_credito'];

    // public function venta(): BelongsTo { return $this->belongsTo(Venta::class)->withTrashed(); }
    public function documentable() { return $this->morphTo(); }
    public function caja_apertura_cierre(): BelongsTo { return $this->belongsTo(CajaAperturaCierre::class); }
    public function caja(): BelongsTo { return $this->belongsTo(Caja::class); }
    public function moneda(): BelongsTo { return $this->belongsTo(Moneda::class); }
    public function tipo_documento(): BelongsTo { return $this->belongsTo(TipoDocumento::class); }
    public function tipo_comprobante(): BelongsTo { return $this->belongsTo(TipoComprobante::class); }
    public function tipo_pago(): BelongsTo { return $this->belongsTo(TipoPago::class); }
    public function tipo_nota_credito(): BelongsTo { return $this->belongsTo(TipoNotaCredito::class); }
    public function detalles(): HasMany { return $this->hasMany(ComprobanteDetalle::class)->withTrashed(); }
    public function cuotas(): HasMany { return $this->hasMany(ComprobanteCuota::class); }
    public function respuestas(): HasMany { return $this->hasMany(ComprobanteFacturacionRespuesta::class); }
    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }
    public function comprobante_modifica(): BelongsTo { return $this->belongsTo(Comprobante::class, 'comprobante_modifica_id', 'id'); }
    public function user_anulacion(): BelongsTo { return $this->belongsTo(User::class, 'anulacion_by', 'id'); }

    public function getSerieCorrelativoAttribute()
    {
        return $this->serie . '-' . $this->correlativo;
    }

    public function getCorrelativoSinCerosAttribute()
    {
        return Str::replace('0', '', $this->correlativo);
    }

    public function getTotalImporteAttribute()
    {
        return $this->detalles->sum('importe');
    }

    public function getExoneradaAttribute()
    {
        return $this->detalles->sum('importe');
    }

    public function getUltimaRespuestaAttribute()
    {
        return $this->respuestas()->orderBy('id', 'desc')->first();
    }

    public function getDisponibleAnulacionAttribute() {
        return $this->fecha_emision->diffInDays(date('Y-m-d')) <= 4;
    }

    public function getDisponibleNotaCreditoAttribute()
    {
        return ($this->fecha_emision->diffInDays(date('Y-m-d')) >= 4 & optional($this->ultima_respuesta ?? null)->errors == null);
    }

    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            $data = FacturacionService::obtenerCorrelativo($model->tipo_comprobante_id, $model->caja_id, Comprobante::find($model->comprobante_modifica_id));
            $model->serie = $data['serie'];
            $model->correlativo = $data['correlativo'];
            $model->created_user_id = Auth::user()->id ?? null;
        });
        static::updating(function($model) {
            $model->updated_user_id = Auth::user()->id ?? null;
        });
        static::restoring(function($model) {
            $model->deleted_user_id = null;
        });
        self::deleting(function($model){
            $model->deleted_user_id = Auth::user()->id ?? null;
            $model->save();
            $model->detalles()->delete();
        });
    }
}
