<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class VueloRuta extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'tipo_vuelo_id',
        'origen_id',
        'destino_id',

        'fecha_hora_vuelo_programado',
        'fecha_hora_aterrizaje_programado',
    ];

    public function tipo_vuelo() : BelongsTo { return $this->belongsTo(TipoVuelo::class); }
    public function vuelos()     : HasMany { return $this->hasMany(Vuelo::class); }

    public function getVueloInicialAttribute()
    {
        return $this->vuelos()->orderBy('stop_number', 'asc')->first();
    }
    public function getVueloFinalAttribute()
    {
        return $this->vuelos()->orderBy('stop_number', 'desc')->first();
    }
    public function getOrigenAttribute()
    {
        return $this->vuelo_inicial->origen;
    }
    public function getDestinoAttribute()
    {
        return $this->vuelo_final->destino;
    }
    public function getDescripcionRutaAttribute()
    {
        return $this->origen->distrito . ' - ' . $this->destino->distrito;
    }

    public function scopeWhereCategoriaId($q, $categoria_id)
    {
        return $q->whereHas('tipo_vuelo', function($q) use ($categoria_id) {
            return $q->where('categoria_vuelo_id', $categoria_id);
        });
    }

    public function scopeFilterSearch(
        $q,
        $search,
        $categoria_id = null,
        // $fecha = null,
        // $from = null,
        // $to = null,
        $desde = null,
        $hasta = null,
        $origen = null,
        $destino = null
    ){
        $search = '%'.$search .'%';
        $q->when($categoria_id, function($q) use ($categoria_id){
            return $q->whereCategoriaId($categoria_id);
        })
        // ->when(
        //     $fecha ||
        //     $from ||
        //     $to ||
        //     $origen ||
        //     $destino,
        //     function($q) use ($fecha, $from, $to, $origen, $destino){
        //         $q->where(function($q) use ($fecha, $from, $to, $origen, $destino){
                    // $q
                    // ->when(isset($origen), function($q) use ($origen){
                    //     return $q->where('origen_id', $origen);
                    // })
                    // ->when(isset($destino), function($q) use ($destino){
                    //     return $q->where('destino_id', $destino);
                    // })
                    // ->when(isset($from), function($q) use ($from,$to){
                    //     if(!isset($to)){
                    //         return $q->whereDate('fecha_hora_vuelo_programado', $from);
                    //     }else{
                    //         return $q->whereDate('fecha_hora_vuelo_programado', '>=', $from);
                    //     }
                    // })
                    // ->when(isset($to), function($q) use ($to){
                    //     return $q->whereDate('fecha_hora_vuelo_programado', '<=', $to);
                    // })
                    // ->when(isset($fecha), function($q) use ($fecha){
                    //     return $q->whereDate('fecha_hora_vuelo_programado', $fecha);
                    // })
                    // ;
        //         });
        // })
        ->when($origen, function ($query) use ($origen) {
            $query->where('origen_id', $origen);
        })
        ->when($destino, function ($query) use ($destino) {
            $query->where('destino_id', $destino);
        })
        ->when($desde, function ($query) use ($desde) {
            $query->whereDate('fecha_hora_vuelo_programado', '>=', $desde);
        })
        ->when($hasta, function ($query) use ($hasta) {
            $query->whereDate('fecha_hora_vuelo_programado', '<=', $hasta);
        })
        ;
    }

    public function getPasajesAttribute(){
        return Pasaje::wherehas('pasaje_vuelos', function($q){
            $q->whereHas('vuelo', function($q){
                return $q->where('vuelo_ruta_id', $this->id);
            });
        })
        ->get();
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
