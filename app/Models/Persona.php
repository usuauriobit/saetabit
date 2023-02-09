<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Persona extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'nacionalidad_id',
        'tipo_documento_id',
        'nro_doc',
        // 'ruc',
        // 'razon_social',
        'ubigeo_id',
        'lugar_nacimiento_id',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'sexo',
        'fecha_nacimiento',
        'photo_url',
    ];

    protected $dates = ['fecha_nacimiento'];

    protected $casts = [
        'fecha_nacimiento' => 'datetime:Y-m-d'
    ];

    public function getNombreCompletoAttribute(){
        return "{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}";
    }
    public function getNombreCompletoInvertidoAttribute(){
        return "{$this->apellido_paterno} {$this->apellido_materno} {$this->nombres}";
    }
    public function getApellidosAttribute(){
        return "{$this->apellido_paterno} {$this->apellido_materno}";
    }
    public function getNombreShortAttribute(){
        $nombre = explode(" ", $this->nombres)[0];
        return "{$nombre} {$this->apellido_paterno}";
    }
    public function getDescAttribute(){
        return $this->nombre_short;
    }
    public function getDocumentoAttribute(){
        return "{$this->nro_doc}";
    }
    public function getImageUrlAttribute(){
        return Storage::url($this->photo_url);
    }
    public function getNombreParcialAttribute(){
        return "{$this->nombres} {$this->apellido_paterno}";
    }
    public function getEdadAttribute(){
        return optional($this->fecha_nacimiento)->age ?? '-';
    }
    public function getSexoDescAttribute(){
        return $this->sexo ? 'M' : 'F';
    }
    public function getUltimoTelefonoAttribute()
    {
        $pasaje = $this->pasajes()->orderBy('fecha', 'desc')->first();
        return $pasaje ? $pasaje->telefono : null;
    }
    public function getPasajesAdquiridosAttribute(){
        return Pasaje::whereHas('venta_detalle.venta', function($q){
            $q->where('clientable_id', $this->id)
            ->where('clientable_type', 'App\Models\Persona');
        })->get();
    }

    public function ventas(){return $this->morphMany(Venta::class, 'clientable');}
    public function cuentas_cobrar() { return $this->morphMany(CuentaCobrar::class, 'clientable'); }
    public function nacionalidad()      : BelongsTo { return $this->belongsTo(Nacionalidad::class); }
    public function tipo_documento()    : BelongsTo { return $this->belongsTo(TipoDocumento::class); }
    public function ubigeo()            : BelongsTo { return $this->belongsTo(Ubigeo::class); }
    public function lugar_nacimiento()  : BelongsTo { return $this->belongsTo(Ubigeo::class, 'lugar_nacimiento_id', 'id'); }
    public function pasajes()           : HasMany { return $this->hasMany(Pasaje::class, 'pasajero_id', 'id')->orderBy('fecha', 'desc'); }
    public function telefonos()         { return $this->morphMany(Telefono::class, 'documentable'); }
    public function guías_remitente() : HasMany { return $this->hasMany(GuiaDespacho::class, 'remitente_id', 'id')->orderBy('fecha', 'desc'); }
    public function guías_consignatario() : HasMany { return $this->hasMany(GuiaDespacho::class, 'consignatario_id', 'id')->orderBy('fecha', 'desc'); }

    public function scopeWhereNombreLike($q, String $search){
        return $q
            ->whereRaw("CONCAT(`nombres`, ' ', `apellido_paterno`, ' ', `apellido_materno`) LIKE '$search'");
    }

    public function scopeFilterDatatable($q, $search){
        return $q->whereNombreLike($search);
    }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id')->withTrashed(); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }
    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            if(Auth::user()){
                $model->user_created_id = Auth::user()->id;
            }
        });
        static::updating(function($model) {
            if(Auth::user()){
                $model->user_updated_id = Auth::user()->id;
            }
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
