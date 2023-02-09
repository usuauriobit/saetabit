<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Oficina extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'ubigeo_id',
        'geo_latitud',
        'geo_longitud',
        'descripcion',
        'direccion',
        'referencia',
        'imagen_path',
        'ruta_facturador',
        'token_facturador',
    ];

    public function getImageUrlAttribute()
    {
        return ($this->imagen_path == null)
            ? asset('img/default/office-icon.png')
            : asset(Storage::url($this->imagen_path)) ;
    }

    public function getTelefonosStringAttribute()
    {
        return $this->telefonos->implode('nro_telefonico', ', ');
    }

    public function ubigeo(): BelongsTo { return $this->belongsTo(Ubigeo::class); }
    public function telefonos() { return $this->morphMany(Telefono::class, 'documentable'); }
    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id')->withTrashed(); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }
    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            $model->user_created_id = Auth::user() ? Auth::user()->id : null;
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
