<?php

namespace App\Models;

use App\Services\TasaCambioService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Descuento extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tipo_descuento_id',
        'categoria_descuento_id',
        'descuento_clasificacion_id',
        'tipo_pasaje_id',
        'ruta_id',
        'descripcion',
        'descuento_porcentaje',
        'descuento_monto',
        'descuento_fijo',
        'fecha_expiracion',
        'codigo_cupon',

        'is_automatico',
        'is_interno',

        'nro_maximo',
        'edad_minima',
        'edad_maxima',

        'is_dolarizado',

        'dias_anticipacion',

        'user_created_id',
        'user_updated_id',
        'user_deleted_id',

        // 'minimo_nro_cupos',

    ];

    protected $dates = [
        'fecha_expiracion'
    ];

    public function getIsPorcentajeAttribute(){
        return !is_null($this->descuento_porcentaje);
    }
    public function getIsTipoPasajeAttribute(){
        return $this->tipo_descuento->descripcion == 'Pasaje';
    }
    public function getIsExpiradoAttribute(){
        return $this->fecha_expiracion->greaterThan(date('Y-m-d'));
    }
    public function getDocumentosAttribute(){
        return $this->pasajes->merge($this->venta_detalles);
    }
    public function getCantidadOcupadaByVuelo(Vuelo $vuelo_origen){
        return $vuelo_origen->pasajes()->where('descuento_id', $this->id)->count();
    }
    public function getCantidadDisponibleByVuelo(Vuelo $vuelo_origen){
        return $this->nro_maximo - $this->getCantidadOcupadaByVuelo($vuelo_origen);
    }
    public function hasCantidadDisponibleByVuelo(Vuelo $vuelo_origen){
        return $this->getCantidadDisponibleByVuelo($vuelo_origen) > 0;
    }

    public function getDescuentoMontoSolesAttribute(){
        return (new TasaCambioService())->getMontoSoles($this->descuento_monto);
    }
    public function getDescuentoFijoSolesAttribute(){
        return (new TasaCambioService())->getMontoSoles($this->descuento_fijo);
    }

    public function scopeWhereAvailable($q, $type, $ruta_id = null){
        $q->where(function($q){
            $q->whereDate('fecha_expiracion', '>=', date('Y-m-d'))
            ->orWhereNull('fecha_expiracion');
        })
        // SABER SI HAY CANTIDAD DISPONIBLE
        ->where(function($q) use ($type) {
            $q->whereNull('nro_maximo')
            ->orWhere(function($q) use ($type) {
                $q->when($type == 'Pasaje', function($q){
                    $q->withCount('pasajes')
                    ->having('pasajes_count', '<', 'descuentos.nro_maximo');
                })
                ->when($type == 'Vuelo', function($q){
                    $q->withCount('venta_detalles')
                    ->having('venta_detalles_count', '<', 'descuentos.nro_maximo');
                });
            });
        })
        // OBTENER POR UNA RUTA ESPECIFICA O QUE NO REQUIERA RUTA
        ->where(function($q) use ($ruta_id) {
            $q->whereNull('ruta_id')
            ->when(!is_null($ruta_id), function($q) use ($ruta_id) {
                $q->orWhere('ruta_id', $ruta_id);
            });
        })
        ->whereType($type);
    }

    public function scopewhereActivos($q){
        $q->where('deleted_at', null)
            ->whereDate('fecha_expiracion', '>=', date('Y-m-d'));
    }
    public function scopewhereExpirados($q){
        $q->whereDate('fecha_expiracion', '<', date('Y-m-d'));
    }

    public function scopeWhereType($q, $type){
        $q->whereHas('tipo_descuento', function($q) use ($type){
            $q->whereDescripcion($type);
        });
    }
    public function scopeWhereForPasajero($q){
        $q->whereType('Pasaje');
    }
    public function scopeWhereForVuelo($q){
        $q->whereType('Vuelo');
    }
    public function scopeWherePublic($q){
        $q->where('is_interno', false);
    }
    public function scopeForIdaVuelta($q, $ruta_id){
        $q->whereRutaId($ruta_id)
            ->where('is_for_ida_vuelta', true);
    }
    public function getMontoSoles(Tarifa $tarifa = null){
        $monto = $this->getMonto($tarifa);
        return $this->is_dolarizado
            ? (new TasaCambioService())->getMontoSoles($monto)
            : $monto;
    }
    public function getMontoDolares(Tarifa $tarifa = null){
        $monto = $this->getMonto($tarifa);
        return $this->is_dolarizado
            ? $monto
            : (new TasaCambioService())->getMontoDolares($monto);
    }

    public function getMonto(Tarifa $tarifa = null){
        $monto = $tarifa->precio ?? 0;
        switch (optional($this->categoria_descuento)->descripcion) {
            case 'Monto restado':
                $monto -= $this->descuento_monto;
                break;
            case 'Porcentaje':
                $monto = $monto - ($this->descuento_porcentaje*$monto)/100;
                break;
            case 'Monto fijo':
                $monto = $this->descuento_fijo;
                break;
        }
        return $monto;
    }
    public function getMontoARestar(Tarifa $tarifa = null){
        $monto = $tarifa->precio ?? 0;
        switch (optional($this->categoria_descuento)->descripcion) {
            case 'Monto restado':
                $monto = $this->descuento_monto;
                break;
            case 'Porcentaje':
                $monto = ($this->descuento_porcentaje*$monto)/100;
                break;
            case 'Monto fijo':
                $monto = $monto - $this->descuento_fijo;
                break;
        }
        return $monto;
    }
    public function getMontoARestarSoles(Tarifa $tarifa = null){
        $monto = $this->getMontoARestar($tarifa);
        return $this->is_dolarizado
            ? (new TasaCambioService())->getMontoSoles($monto)
            : $monto;
    }
    public function getMontoARestarDolares(Tarifa $tarifa = null){
        $monto = $this->getMontoARestar($tarifa);
        return $this->is_dolarizado
            ? $monto
            : (new TasaCambioService())->getMontoDolares($monto);
    }
    public function getStateAttribute(){
        if($this->trashed()) return 'Eliminado';
        if($this->fecha_expiracion && $this->fecha_expiracion->lessThan(new Carbon())) return 'Expirado';
        return 'Activo';
    }
    public function getBadgeStateAttribute(){
        switch ($this->state) {
            case 'Eliminado':
                return  'badge-error';
            case 'Expirado':
                return  'badge-warning';
            default:
                return 'badge-success';
        }
    }

    public function tipo_descuento()        : BelongsTo { return $this->belongsTo(TipoDescuento::class)->withTrashed(); }
    public function tipo_pasaje()        : BelongsTo { return $this->belongsTo(TipoPasaje::class); }
    public function categoria_descuento()   : BelongsTo { return $this->belongsTo(CategoriaDescuento::class); }
    public function descuento_clasificacion()   : BelongsTo { return $this->belongsTo(DescuentoClasificacion::class); }
    public function ruta()          : BelongsTo { return $this->belongsTo(Ruta::class); }

    public function pasajes()       : HasMany{ return $this->hasMany(Pasaje::class);}
    public function venta_detalles() {return $this->morphMany(VentaDetalle::class, 'documentable');}
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
