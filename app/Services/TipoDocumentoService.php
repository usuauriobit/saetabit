<?php

namespace App\Services;

use App\Models\TipoDocumento;

class TipoDocumentoService {
    public static function getTipoDocumento($descripcion){
        $tipo_documento = TipoDocumento::query();
        if(is_numeric($descripcion)){
            return $tipo_documento->where('id', $descripcion)->first();
        }
        return $tipo_documento->where('descripcion', $descripcion)->first();
    }
    public static function getId($descripcion){
        $tipo_documento = self::getTipoDocumento($descripcion);
        return $tipo_documento->id ?? null;
    }
}
