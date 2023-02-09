<?php

namespace App\Rules\Caja;

use App\Models\TipoComprobante;
use App\Models\TipoDocumento;
use Illuminate\Contracts\Validation\Rule;

class TipoDocumentoFactura implements Rule
{
    public $nro_documento;
    public $tipo_comprobante_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($nro_documento, $tipo_comprobante_id = null)
    {
        $this->nro_documento = $nro_documento;
        $this->tipo_comprobante_id = $tipo_comprobante_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tipo_documento = TipoDocumento::find($value);
        $tipo_comprobante = TipoComprobante::find($this->tipo_comprobante_id);

        if (isset($tipo_documento, $tipo_comprobante)) {
            if ($tipo_documento->descripcion == 'RUC' & strlen($this->nro_documento) == 11 & $tipo_comprobante->descripcion == 'Factura')
                return true;

            if ($tipo_documento->descripcion != 'RUC' & strlen($this->nro_documento) == 8 & $tipo_comprobante->descripcion == 'Boleta')
            // if ($tipo_comprobante->descripcion == 'Boleta')
                return true;

            if ($tipo_comprobante->descripcion == 'Nota de Crédito')
                return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El tipo de documento no coicide con el comprobante a emitir';
    }
}
