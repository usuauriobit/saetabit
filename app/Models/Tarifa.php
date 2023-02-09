<?php

namespace App\Models;

use App\Services\TasaCambioService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tarifa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ruta_id',
        'tipo_pasaje_id',
        'descripcion',
        'precio',
        'ocupa_asiento',
        'maximo_equipaje',
        'is_dolarizado',
    ];

    protected $appends = [
        'edad_minima',
        'edad_maxima'
    ];

    public function getEdadMinimaAttribute(){
        return $this->tipo_pasaje->edad_minima;
    }
    public function getEdadMaximaAttribute(){
        return $this->tipo_pasaje->edad_maxima;
    }

    public function getHasEscalaAttribute(){
        return (bool) optional(optional($this->ruta)->tramo)->escala;
    }
    public function getPrecioSolesAttribute(){
        return $this->is_dolarizado
            ? (new TasaCambioService())->getMontoSoles($this->precio)
            : $this->precio;
    }
    public function getPrecioDolaresAttribute(){
        return $this->is_dolarizado
            ? $this->precio
            : (new TasaCambioService())->getMontoDolares($this->precio);
    }

    public function getInversoAttribute(){
        $ruta_inversa = $this->ruta->inverso;
        return Tarifa::where('ruta_id', $ruta_inversa->id)
            ->where('tipo_pasaje_id', $this->tipo_pasaje_id)
            ->where('descripcion', $this->descripcion)
            ->first();
    }

    public function ruta(): BelongsTo { return $this->belongsTo(Ruta::class); }
    public function tipo_pasaje(): BelongsTo { return $this->belongsTo(TipoPasaje::class); }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id')->withTrashed(); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }
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
