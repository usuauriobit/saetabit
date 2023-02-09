<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Devolucion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'oficina_id',
        'placelable_id',
        'placelable_type',
        'devolucion_motivo_id',
        'reviewed_by_id',
        'banco_id',
        'importe',
        'gastos_administrativos',
        'fecha',
        'observacion',
        'nro_cuenta_bancaria',
        'status_reviewed',
        'date_reviewed',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
    ];

    protected $dates = ['fecha', 'date_reviewed'];

    public function oficina(): BelongsTo { return $this->belongsTo(Oficina::class); }
    public function banco(): BelongsTo { return $this->belongsTo(Banco::class); }
    public function devolucion_motivo(): BelongsTo { return $this->belongsTo(DevolucionMotivo::class); }
    public function placelable() { return $this->morphTo()->withTrashed(); }
    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id'); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id'); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id'); }
    public function reviewed_by(): BelongsTo { return $this->belongsTo(User::class, 'reviewed_by_id', 'id'); }

    public function getCodigoAttribute()
    {
        return 'D-' . Str::padLeft($this->id, 6, '0');
    }
    public function getImporteDevolucionAttribute()
    {
        return $this->importe - $this->gastos_administrativos;
    }
    public function getColorStatusAttribute()
    {
        if ($this->status_reviewed == 'Aprobado')
            return 'success';
        if ($this->status_reviewed == 'Rechazado')
            return 'error';

        return 'warning';
    }

    public static function booted()
    {
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
