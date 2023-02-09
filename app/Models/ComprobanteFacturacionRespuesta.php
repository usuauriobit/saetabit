<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComprobanteFacturacionRespuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'comprobante_id',
        'tipo_de_comprobante',
        'serie',
        'numero',
        'enlace',
        'enlace_del_pdf',
        'enlace_del_xml',
        'enlace_del_cdr',
        'aceptada_por_sunat',
        'sunat_description',
        'sunat_note',
        'sunat_responsecode',
        'sunat_soap_error',
        'cadena_para_codigo_qr',
        'codigo_hash',
        'errors',
    ];

    public function comprobante(): BelongsTo { return $this->belongsTo(Comprobante::class); }
}
